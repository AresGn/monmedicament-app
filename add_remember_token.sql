-- Script pour ajouter la colonne remember_token à la table users
ALTER TABLE users ADD COLUMN remember_token VARCHAR(100) NULL; 