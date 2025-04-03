import React from 'react';
import { 
  ChevronLeft, 
  Check, 
  MapPin, 
  Clock, 
  AlertCircle,
  FileText
} from 'lucide-react';

const VerificationPage = () => {
  return (
    <div className="min-h-screen pt-16 bg-gray-50">
      {/* Progress Bar Header */}
      <div className="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-40">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex items-center space-x-4">
            <button className="flex items-center text-gray-600 hover:text-teal-600">
              <ChevronLeft size={20} />
              <span>Retour</span>
            </button>
            <div className="flex-grow flex justify-center">
              <div className="flex items-center space-x-4">
                <div className="flex items-center">
                  <div className="w-8 h-8 rounded-full bg-teal-600 text-white flex items-center justify-center">
                    <Check size={16} />
                  </div>
                  <div className="ml-2">
                    <span className="text-sm font-medium text-teal-600">Ordonnance</span>
                  </div>
                </div>
                <div className="w-16 h-1 bg-teal-600"></div>
                <div className="flex items-center">
                  <div className="w-8 h-8 rounded-full bg-teal-600 text-white flex items-center justify-center">2</div>
                  <div className="ml-2">
                    <span className="text-sm font-medium text-teal-600">Vérification</span>
                  </div>
                </div>
                <div className="w-16 h-1 bg-gray-200"></div>
                <div className="flex items-center">
                  <div className="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center">3</div>
                  <div className="ml-2">
                    <span className="text-sm font-medium text-gray-600">Confirmation</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Main Content */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Main Column */}
          <div className="lg:col-span-2">
            <div className="bg-white rounded-lg shadow-sm p-6 mb-6">
              <h2 className="text-xl font-semibold text-gray-800 mb-4">Vérification de l'ordonnance</h2>
              
              <div className="bg-green-50 rounded-lg p-4 flex items-start gap-3 mb-6">
                <Check className="text-green-600 mt-1" size={20} />
                <div>
                  <h3 className="font-semibold text-green-800">Ordonnance validée</h3>
                  <p className="text-green-700 text-sm">Votre ordonnance a été vérifiée et correspond aux médicaments disponibles.</p>
                </div>
              </div>

              <div className="space-y-4">
                {['Paracétamol 1000mg', 'Amoxicilline 500mg', 'Ibuprofène 200mg'].map((medicine, index) => (
                  <div key={index} className="flex justify-between py-3 border-b border-gray-200 last:border-0">
                    <span className="text-gray-800">{medicine}</span>
                    <span className="text-gray-600">1 boîte</span>
                  </div>
                ))}
              </div>
            </div>

            <div className="bg-white rounded-lg shadow-sm p-6">
              <h2 className="text-xl font-semibold text-gray-800 mb-4">Instructions supplémentaires</h2>
              <textarea 
                className="w-full border border-gray-200 rounded-lg p-3 h-32 resize-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                placeholder="Instructions supplémentaires pour le pharmacien..."
              />
            </div>
          </div>

          {/* Side Column */}
          <div className="lg:col-span-1">
            <div className="bg-white rounded-lg shadow-sm p-6 mb-6">
              <h2 className="text-xl font-semibold text-gray-800 mb-4">Pharmacie sélectionnée</h2>
              <div className="flex gap-4">
                <div className="w-20 h-20 bg-gray-100 rounded-lg"></div>
                <div>
                  <h3 className="font-semibold text-gray-800">Pharmacie Centrale</h3>
                  <p className="text-gray-600 text-sm flex items-center gap-1 mt-1">
                    <MapPin size={16} />
                    123 Avenue de la République, Paris
                  </p>
                  <p className="text-gray-600 text-sm flex items-center gap-1 mt-1">
                    <Clock size={16} />
                    Ouvert jusqu'à 20h
                  </p>
                </div>
              </div>
            </div>

            <div className="bg-white rounded-lg shadow-sm p-6 mb-6">
              <h2 className="text-xl font-semibold text-gray-800 mb-4">Récapitulatif de la commande</h2>
              <div className="space-y-3">
                <div className="flex justify-between text-gray-600">
                  <span>Sous-total</span>
                  <span>42.50 €</span>
                </div>
                <div className="flex justify-between text-gray-600">
                  <span>Frais de service</span>
                  <span>2.50 €</span>
                </div>
                <div className="flex justify-between text-gray-800 font-semibold pt-3 border-t">
                  <span>Total</span>
                  <span>45.00 €</span>
                </div>
              </div>
            </div>

            <div className="bg-amber-50 rounded-lg p-4 mb-6 flex gap-3">
              <AlertCircle className="text-amber-600 mt-1" size={20} />
              <div>
                <h3 className="font-semibold text-amber-800">Note importante</h3>
                <p className="text-amber-700 text-sm">L'ordonnance originale devra être présentée lors du retrait.</p>
              </div>
            </div>

            <div className="space-y-3">
              <button className="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition-colors">
                Confirmer la commande
              </button>
              <button className="w-full bg-white border border-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition-colors">
                Modifier la commande
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default VerificationPage;