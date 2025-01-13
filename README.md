# Youdemy - Plateforme de Cours en Ligne

## Contexte du Projet
Youdemy est une plateforme de cours en ligne visant à révolutionner l’apprentissage en proposant un système interactif et personnalisé pour les étudiants et les enseignants.

---

## Fonctionnalités Requises

### Partie Front Office

#### Visiteur
- Accès au catalogue des cours avec pagination.
- Recherche de cours par mots-clés.
- Création d’un compte avec le choix du rôle (Etudiant ou Enseignant).

#### Etudiant
- Visualisation du catalogue des cours.
- Recherche et consultation des détails des cours (description, contenu, enseignant, etc.).
- Inscription à un cours après authentification.
- Accès à une section “Mes cours” regroupant les cours rejoints.

#### Enseignant
- Ajout de nouveaux cours avec des détails tels que :
  - Titre
  - Description
  - Contenu (vidéo ou document)
  - Tags
  - Catégorie
- Gestion des cours :
  - Modification
  - Suppression
  - Consultation des inscriptions
- Accès à une section “Statistiques” sur les cours :
  - Nombre d’étudiants inscrits
  - Nombre de cours
  - Autres statistiques pertinentes

---

### Partie Back Office

#### Administrateur
- Validation des comptes enseignants.
- Gestion des utilisateurs :
  - Activation
  - Suspension
  - Suppression
- Gestion des contenus :
  - Cours
  - Catégories
  - Tags
  - Insertion en masse de tags pour gagner en efficacité.
- Accès à des statistiques globales :
  - Nombre total de cours
  - Répartition par catégorie
  - Le cours avec le plus d’étudiants
  - Les Top 3 enseignants

---

## Fonctionnalités Transversales

- Un cours peut contenir plusieurs tags (relation many-to-many).
- Application du concept de polymorphisme dans les méthodes suivantes :
  - Ajouter cours
  - Afficher cours
- Système d’authentification et d’autorisation pour protéger les routes sensibles.
- Contrôle d’accès : chaque utilisateur ne peut accéder qu’aux fonctionnalités correspondant à son rôle.

---

## Exigences Techniques

- Respect des principes OOP (encapsulation, héritage, polymorphisme).
- Base de données relationnelle avec gestion des relations (one-to-many, many-to-many).
- Utilisation des sessions PHP pour la gestion des utilisateurs connectés.
- Système de validation des données utilisateur pour garantir la sécurité.

---

### Contribuez
N’hésitez pas à participer à l’amélioration de Youdemy en proposant des suggestions, signalant des problèmes ou en soumettant des pull requests.

### License
Ce projet est sous licence [MIT](LICENSE).

**Bon apprentissage avec Youdemy !**

