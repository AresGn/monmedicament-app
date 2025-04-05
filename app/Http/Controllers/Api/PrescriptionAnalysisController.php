<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrescriptionAnalysisController extends Controller
{
    /**
     * Analyse une image d'ordonnance et renvoie les médicaments identifiés
     */
    public function analyze(Request $request)
    {
        // Validation de la requête
        $request->validate([
            'ordonnance' => 'required|image|max:10240', // Max 10MB
        ]);

        try {
            // Récupération du fichier
            $file = $request->file('ordonnance');
            
            // Génération d'un nom de fichier unique
            $filename = uniqid('prescription_') . '.' . $file->getClientOriginalExtension();
            
            // Log pour debug
            Log::info('Analyse d\'ordonnance - Fichier reçu: ' . $filename);
            
            // Lecture du fichier en base64
            $imageContents = file_get_contents($file->getRealPath());
            $base64Image = base64_encode($imageContents);
            $mimeType = $file->getMimeType();
            $base64Data = "data:{$mimeType};base64,{$base64Image}";
            
            Log::info('Image encodée en base64');

            // Préparation de la requête vers OpenRouter API
            $apiKey = env('OPENROUTER_API_KEY');
            
            if (!$apiKey) {
                Log::error('Clé API OpenRouter manquante');
                return response()->json([
                    'success' => false,
                    'message' => 'Clé API OpenRouter non configurée. Veuillez ajouter votre clé API dans le fichier .env.',
                ], 500);
            }

            // Préparation de la requête avec cURL
            try {
                // Initialisation de cURL
                $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
                
                // Construction des données JSON
                $appUrl = env('APP_URL', 'http://localhost');
                $appName = env('APP_NAME', 'MonMédicament');
                
                $requestData = [
                    'model' => 'qwen/qwen2.5-vl-3b-instruct:free',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Identifie tous les médicaments présents sur cette ordonnance. Renvoie uniquement une liste des noms de médicaments et leur dosage au format JSON, sans aucun autre texte. Par exemple: [{"nom": "Paracétamol", "dosage": "1000mg"}, {"nom": "Amoxicilline", "dosage": "500mg"}]'
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => $base64Data
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];
                
                // Configuration de cURL
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactive la vérification SSL
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Désactive la vérification du nom d'hôte
                curl_setopt($ch, CURLOPT_TIMEOUT, 120); // Timeout de 2 minutes
                
                // En-têtes
                $headers = [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $apiKey,
                    'HTTP-Referer: ' . $appUrl,
                    'X-Title: ' . $appName,
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                // Exécution de la requête
                Log::info('Exécution de la requête cURL vers OpenRouter');
                $response = curl_exec($ch);
                
                // Vérification des erreurs cURL
                if ($response === false) {
                    $curlError = curl_error($ch);
                    $curlErrno = curl_errno($ch);
                    Log::error("Erreur cURL: {$curlError} (code: {$curlErrno})");
                    curl_close($ch);
                    
                    return response()->json([
                        'success' => false,
                        'message' => "Erreur de communication avec l'API: {$curlError}",
                        'error' => "Code cURL: {$curlErrno}",
                    ], 500);
                }
                
                // Récupération du code HTTP
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                Log::info("Code HTTP reçu: {$httpCode}");
                
                // Fermeture de la connexion cURL
                curl_close($ch);
                
                // Décodage de la réponse
                $result = json_decode($response, true);
                Log::info("Réponse reçue: " . json_encode($result));
                
                // Traitement de la réponse
                if ($httpCode >= 200 && $httpCode < 300 && $result) {
                    // Extraction du texte à partir de la réponse
                    $content = $result['choices'][0]['message']['content'] ?? null;
                    
                    if (!$content) {
                        Log::warning('Réponse OpenRouter sans contenu');
                        return response()->json([
                            'success' => false,
                            'message' => 'Réponse vide de l\'API d\'analyse d\'image',
                            'error' => 'Aucun contenu dans la réponse',
                        ], 500);
                    }
                    
                    // Tentative de décodage JSON si le format est correct
                    $medicines = null;
                    try {
                        $medicines = json_decode($content, true);
                        // Si le décodage échoue mais que le contenu ressemble à du JSON
                        if ($medicines === null && (strpos($content, '[') === 0 || strpos($content, '{') === 0)) {
                            // Nettoyage du contenu pour éliminer les caractères non-JSON
                            $cleanedContent = preg_replace('/```json\s*|\s*```/', '', $content);
                            Log::info("Tentative de décodage JSON nettoyé: " . $cleanedContent);
                            $medicines = json_decode($cleanedContent, true);
                        }
                    } catch (\Exception $e) {
                        // Si ce n'est pas du JSON, on essaie d'extraire les médicaments du texte
                        Log::warning('Réponse non-JSON reçue: ' . $content . ' - Erreur: ' . $e->getMessage());
                    }
                    
                    // Si la réponse n'est pas du JSON ou est vide
                    if (!is_array($medicines) || empty($medicines)) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Analyse terminée, le texte nécessite un traitement manuel',
                            'raw_content' => $content,
                            'medicines' => [],
                        ]);
                    }
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Médicaments identifiés avec succès',
                        'medicines' => $medicines,
                    ]);
                } else {
                    // Erreur de l'API
                    Log::error('Erreur API OpenRouter: ' . $response);
                    
                    $errorMessage = 'Erreur lors de l\'analyse de l\'ordonnance';
                    if (isset($result['error']['message'])) {
                        $errorMessage .= ': ' . $result['error']['message'];
                    }
                    
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                        'error' => $result['error'] ?? $response,
                    ], 500);
                }
                
            } catch (\Exception $e) {
                Log::error('Exception lors de l\'appel API: ' . $e->getMessage() . ' - Trace: ' . $e->getTraceAsString());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors du traitement de la requête: ' . $e->getMessage(),
                    'error' => $e->getMessage(),
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Erreur d\'analyse d\'ordonnance: ' . $e->getMessage() . ' - Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'analyse de l\'ordonnance: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
} 