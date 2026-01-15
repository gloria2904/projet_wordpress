-- =====================================================
-- Données de démonstration pour GreenTech Solutions
-- À importer après l'installation du plugin
-- =====================================================

-- Remplacez 'wp_' par votre préfixe de table WordPress si différent

-- Insertion de demandes de devis de test
INSERT INTO wp_demandes_devis (nom, email, telephone, entreprise, service, message, statut, date_creation) VALUES
('Sophie Martin', 'sophie.martin@exemple-entreprise.fr', '01 23 45 67 89', 'TechCorp SARL', 'audit', 'Bonjour, nous souhaitons réaliser un audit énergétique complet de nos bureaux de 500m². Nous cherchons à réduire notre consommation et notre empreinte carbone. Pouvez-vous nous proposer un devis ?', 'nouveau', NOW() - INTERVAL 2 DAY),

('Jean Dupont', 'j.dupont@logistique-pro.com', '06 12 34 56 78', 'Logistique Pro', 'panneaux', 'Nous avons un entrepôt de 2000m² et souhaitons installer des panneaux solaires sur le toit. Quelle puissance recommandez-vous ? Budget approximatif ?', 'en_cours', NOW() - INTERVAL 5 DAY),

('Marie Leclerc', 'marie.leclerc@innovatech.fr', '04 56 78 90 12', 'InnovaTech Industries', 'optimisation', 'Notre usine consomme beaucoup d\'énergie. Nous cherchons des solutions pour optimiser notre consommation sans impacter la production. Disponible pour un RDV la semaine prochaine.', 'nouveau', NOW() - INTERVAL 1 DAY),

('Pierre Dubois', 'p.dubois@greenoffice.fr', '01 98 76 54 32', 'Green Office Solutions', 'audit', 'Audit énergétique pour nos 3 sites en Île-de-France (Paris, Nanterre, Créteil). Besoin d\'un devis global. Merci.', 'traite', NOW() - INTERVAL 15 DAY),

('Claire Bernard', 'claire.b@restaurant-bio.fr', '06 34 56 78 90', 'Le Restaurant Bio', 'panneaux', 'Restaurant avec terrasse, possibilité d\'installer des panneaux solaires ? Budget limité mais projet écologique important pour nous.', 'nouveau', NOW() - INTERVAL 3 HOUR),

('Thomas Rousseau', 'thomas.rousseau@coworking-plus.com', '07 12 34 56 78', 'CoWorking Plus', 'optimisation', 'Espace de coworking 800m², nous voulons devenir 100% énergie verte. Que proposez-vous ? Possibilité de panneaux + optimisation ?', 'en_cours', NOW() - INTERVAL 7 DAY),

('Isabelle Moreau', 'i.moreau@pharmaco-lab.fr', '01 45 67 89 01', 'Pharmaco Lab', 'audit', 'Laboratoire pharmaceutique, contraintes strictes de température. Audit énergétique spécialisé nécessaire. Budget conséquent.', 'nouveau', NOW() - INTERVAL 12 HOUR),

('Laurent Petit', 'laurent.petit@startup-tech.io', '06 78 90 12 34', 'StartUp Tech', 'autre', 'Startup en croissance, bureaux 300m². Recherchons solution globale : audit + panneaux + optimisation. Projet à long terme.', 'nouveau', NOW() - INTERVAL 1 HOUR),

('Nathalie Garnier', 'ngarnier@hotel-moderne.fr', '04 23 45 67 89', 'Hôtel Moderne', 'panneaux', 'Hôtel 3 étoiles, 40 chambres. Projet d\'installation de panneaux solaires pour l\'eau chaude sanitaire. Subventions possibles ?', 'traite', NOW() - INTERVAL 20 DAY),

('François Leroy', 'f.leroy@cabinet-medical.com', '01 34 56 78 90', 'Cabinet Médical Central', 'optimisation', 'Cabinet médical avec beaucoup d\'équipements énergivores (scanner, radio, etc.). Comment réduire notre facture sans compromettre les soins ?', 'en_cours', NOW() - INTERVAL 4 DAY);
