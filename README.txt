=== GreenTech Solutions - Thème et Plugin WordPress ===

Contributeurs: Votre Nom
Version: 1.0.0
Testé jusqu'à: WordPress 6.4
License: GPLv2 ou ultérieure

== Description ==

Thème WordPress personnalisé pour GreenTech Solutions avec plugin de gestion de demandes de devis intégré.

== Installation ==

### 1. Installation du Thème

1. Téléchargez le dossier `greentech` 
2. Placez-le dans `/wp-content/themes/`
3. Dans l'admin WordPress, allez dans **Apparence > Thèmes**
4. Activez le thème "GreenTech Solutions"
5. Le rôle "Commercial" sera créé automatiquement

### 2. Installation du Plugin

1. Téléchargez le dossier `demandes-devis`
2. Placez-le dans `/wp-content/plugins/`
3. Dans l'admin WordPress, allez dans **Extensions**
4. Activez le plugin "Demandes de Devis"
5. La table en base de données sera créée automatiquement

== Configuration ==

### 1. Configurer le Menu

1. Allez dans **Apparence > Menus**
2. Créez un nouveau menu (ex: "Menu Principal")
3. Ajoutez des liens personnalisés vers :
   - #services (Services)
   - #projets (Projets)
   - #about (À propos)
   - #contact (Contact)
4. Assignez ce menu à l'emplacement "Menu Principal"

### 2. Configurer le Widget "Nos Projets"

1. Allez dans **Apparence > Widgets**
2. Trouvez le widget "Nos Derniers Projets"
3. Glissez-le dans la zone "Projets Widget Area"
4. Configurez les 3 projets :
   - Titre du projet
   - Description
   - URL de l'image
5. Enregistrez

### 3. Configurer le Bandeau Promotionnel

#### Pour les Administrateurs :
1. Allez dans **Apparence > Paramètres Thème**
2. Modifiez le texte du bandeau
3. Activez/désactivez l'affichage
4. Enregistrez

#### Pour les Commerciaux :
1. Allez dans **Apparence > Bandeau Promo**
2. Modifiez le texte
3. Activez/désactivez
4. Enregistrez

### 4. Personnaliser la Page d'Accueil

1. Allez dans **Pages > Ajouter**
2. Créez une page avec le titre "Accueil"
3. Publiez sans contenu (le template front-page.php s'appliquera automatiquement)
4. Allez dans **Réglages > Lecture**
5. Sélectionnez "Une page statique"
6. Choisissez "Accueil" comme page d'accueil

## Utilisation du Plugin "Demandes de Devis"

### Affichage du Formulaire

Le formulaire s'affiche automatiquement sur la page d'accueil dans la section Contact.

Pour l'afficher ailleurs, utilisez le shortcode ou la fonction PHP :
```php
<?php
if (function_exists('display_devis_form')) {
    display_devis_form();
}
?>
```

### Consulter les Demandes

1. Dans l'admin WordPress, cliquez sur **Demandes Devis** dans le menu
2. Vous verrez la liste de toutes les demandes avec :
   - Statistiques (Total, Nouveaux, En cours, Traités)
   - Liste détaillée des demandes
3. Cliquez sur "Voir" pour voir les détails d'une demande
4. Modifiez le statut (Nouveau / En cours / Traité)

### Gestion des Statuts

- **Nouveau** : Demande non traitée (vert)
- **En cours** : Demande en cours de traitement (orange)
- **Traité** : Demande terminée (gris)

## Rôle "Commercial"

### Capacités du Commercial

Le rôle Commercial peut :
- ✅ Consulter toutes les demandes de devis
- ✅ Voir les détails des demandes
- ✅ Modifier les statuts des demandes
- ✅ Modifier le bandeau promotionnel
- ❌ Ne peut PAS modifier les pages/articles
- ❌ Ne peut PAS modifier la structure du site
- ❌ Ne peut PAS installer/désinstaller de plugins

### Créer un Utilisateur Commercial

1. Allez dans **Utilisateurs > Ajouter**
2. Remplissez les informations
3. Dans "Rôle", sélectionnez **Commercial**
4. Cliquez sur "Ajouter un utilisateur"

## Structure des Fichiers

### Thème (greentech/)
```
greentech/
├── style.css                 # CSS principal + informations du thème
├── functions.php            # Fonctions principales
├── header.php               # En-tête
├── footer.php               # Pied de page
├── index.php                # Template par défaut
├── front-page.php           # Page d'accueil (Landing Page)
├── inc/
│   ├── custom-roles.php     # Gestion du rôle Commercial
│   └── widgets/
│       └── projets-widget.php # Widget Nos Projets
└── assets/
    ├── css/
    ├── js/
    │   └── main.js
    └── images/
```

### Plugin (demandes-devis/)
```
demandes-devis/
├── demandes-devis.php       # Fichier principal
├── includes/
│   ├── class-devis-db.php   # Gestion BDD
│   ├── class-devis-form.php # Formulaire front-end
│   └── class-devis-admin.php # Interface admin
└── assets/
    ├── css/
    │   ├── form-style.css
    │   └── admin-style.css
    └── js/
        └── form-script.js   # AJAX pour le formulaire
```

## Hooks Personnalisés

### Hook `greentech_after_header`

Ce hook s'exécute juste après le header et affiche le bandeau promotionnel.

**Utilisation :**
```php
// Ajouter du contenu après le header
add_action('greentech_after_header', 'ma_fonction_custom');
function ma_fonction_custom() {
    echo '<div>Mon contenu personnalisé</div>';
}
```

## Customisation Avancée

### Modifier les Services

Éditez le fichier `front-page.php`, section "Services" (ligne ~40)

### Modifier les Couleurs

Les couleurs sont définies dans `style.css` avec des variables CSS :
```css
:root {
    --primary: #2d5a27;        /* Vert principal */
    --primary-light: #4a7c2c;  /* Vert clair */
    --accent: #00d2ff;          /* Bleu accent */
}
```

### Ajouter des Champs au Formulaire

1. Modifier `includes/class-devis-form.php` (méthode `display_form()`)
2. Ajouter les champs en base de données dans `includes/class-devis-db.php`
3. Mettre à jour la méthode `create_table()`

## Dépannage

### Le formulaire ne s'envoie pas
- Vérifiez que le plugin est activé
- Vérifiez les erreurs dans la console JavaScript (F12)
- Vérifiez que jQuery est chargé

### Le widget ne s'affiche pas
- Vérifiez qu'il est bien placé dans "Projets Widget Area"
- Vérifiez que les 3 projets sont configurés

### Le bandeau ne s'affiche pas
- Vérifiez qu'il est activé dans les paramètres
- Vérifiez que le texte n'est pas vide

### Le menu ne s'affiche pas
- Créez un menu dans Apparence > Menus
- Assignez-le à "Menu Principal"

## Support

Pour toute question ou problème :
- Email : votre-email@example.com
- Documentation : https://votre-site.com/docs

== Changelog ==

= 1.0.0 =
* Version initiale
* Thème personnalisé avec intégration HTML/CSS
* Plugin de gestion de devis
* Widget Nos Projets
* Rôle Commercial
* Hook after_header
* Bandeau promotionnel configurable