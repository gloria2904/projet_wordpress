<!DOCTYPE html>
<html lang="fr">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>GreenTech Solutions</title>
      <style>
            /* Variables pour une maintenance facile et un look cohérent */
            :root {
                  --primary: #2d5a27;
                  --primary-light: #4a7c2c;
                  --accent: #00d2ff;
                  /* Touche de bleu moderne pour l'énergie */
                  --bg-light: #fdfdfd;
                  --text-dark: #1a1a1a;
                  --text-muted: #636e72;
                  --white: #ffffff;
                  --shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            * {
                  margin: 0;
                  padding: 0;
                  box-sizing: border-box;
            }

            body {
                  font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
                  line-height: 1.7;
                  color: var(--text-dark);
                  background-color: var(--bg-light);
                  scroll-behavior: smooth;
            }

            .container {
                  max-width: 1140px;
                  margin: 0 auto;
                  padding: 0 24px;
            }

            /* Header - Effet de verre (Glassmorphism) */
            .site-header {
                  background: rgba(45, 80, 22, 0.95);
                  backdrop-filter: blur(10px);
                  color: white;
                  padding: 1rem 0;
                  position: sticky;
                  top: 0;
                  z-index: 1000;
                  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .site-header .container {
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
            }

            .logo h1 {
                  font-size: 1.5rem;
                  letter-spacing: -0.5px;
            }

            .main-nav ul {
                  display: flex;
                  list-style: none;
                  gap: 2.5rem;
            }

            .main-nav a {
                  color: white;
                  text-decoration: none;
                  font-weight: 500;
                  font-size: 0.95rem;
                  transition: var(--transition);
                  opacity: 0.9;
            }

            .main-nav a:hover {
                  color: var(--accent);
                  opacity: 1;
            }

            /* Bandeau promotionnel - Plus discret et élégant */
            .promo-banner {
                  background: #fff9db;
                  color: #856404;
                  text-align: center;
                  padding: 0.6rem;
                  font-size: 0.85rem;
                  text-transform: uppercase;
                  letter-spacing: 1px;
                  font-weight: 700;
            }

            /* Hero Section - Gradient moderne et espacement */
            .hero {
                  background: radial-gradient(circle at top right, #4a7c2c, #2d5016);
                  color: white;
                  padding: 8rem 0;
                  text-align: center;
                  position: relative;
                  overflow: hidden;
            }

            .hero::after {
                  content: '';
                  position: absolute;
                  bottom: 0;
                  left: 0;
                  right: 0;
                  height: 50px;
                  background: var(--bg-light);
                  clip-path: polygon(0 100%, 100% 100%, 100% 0);
            }

            .hero-content h2 {
                  font-size: clamp(2rem, 5vw, 3.5rem);
                  margin-bottom: 1.5rem;
                  font-weight: 800;
                  line-height: 1.1;
            }

            .hero-content p {
                  font-size: 1.25rem;
                  margin-bottom: 2.5rem;
                  max-width: 700px;
                  margin-left: auto;
                  margin-right: auto;
                  opacity: 0.9;
            }

            .cta-button {
                  display: inline-block;
                  background: var(--white);
                  color: var(--primary);
                  padding: 1.2rem 3rem;
                  border-radius: 12px;
                  text-decoration: none;
                  font-weight: 700;
                  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
                  transition: var(--transition);
            }

            .cta-button:hover {
                  transform: translateY(-3px);
                  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
                  background: var(--accent);
                  color: var(--white);
            }

            /* Services Section - Cartes minimalistes */
            .services {
                  padding: 7rem 0;
            }

            .services h2 {
                  text-align: center;
                  font-size: 2.2rem;
                  margin-bottom: 4rem;
                  position: relative;
                  padding-bottom: 15px;
            }

            .services h2::after {
                  content: '';
                  position: absolute;
                  bottom: 0;
                  left: 50%;
                  transform: translateX(-50%);
                  width: 60px;
                  height: 4px;
                  background: var(--primary-light);
                  border-radius: 2px;
            }

            .services-grid {
                  display: grid;
                  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                  gap: 2.5rem;
            }

            .service-card {
                  background: var(--white);
                  padding: 3rem 2rem;
                  border-radius: 24px;
                  border: 1px solid rgba(0, 0, 0, 0.03);
                  box-shadow: var(--shadow);
                  text-align: center;
                  transition: var(--transition);
            }

            .service-card:hover {
                  transform: translateY(-10px);
                  border-color: var(--primary-light);
            }

            .service-icon {
                  font-size: 3.5rem;
                  margin-bottom: 1.5rem;
                  display: block;
                  filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
            }

            .service-card h3 {
                  margin-bottom: 1rem;
                  font-size: 1.4rem;
                  font-weight: 700;
            }

            .service-card p {
                  color: var(--text-muted);
                  font-size: 1rem;
            }

            /* Sidebar Area - Look "Card" */
            .sidebar-widget-area {
                  background: var(--white);
                  padding: 3rem;
                  margin: 2rem auto;
                  max-width: 1140px;
                  border-radius: 24px;
                  border: 2px dashed #e0e0e0;
                  text-align: center;
                  color: var(--text-muted);
            }

            /* Contact Section - Inputs arrondis et épurés */
            .contact {
                  padding: 7rem 0;
            }

            .contact-form {
                  max-width: 550px;
                  margin: 0 auto;
                  background: var(--white);
                  padding: 3rem;
                  border-radius: 30px;
                  box-shadow: var(--shadow);
            }

            .contact-form input,
            .contact-form textarea {
                  width: 100%;
                  padding: 1.2rem;
                  margin-bottom: 1.2rem;
                  border: 1px solid #eee;
                  background: #f8f9fa;
                  border-radius: 12px;
                  transition: var(--transition);
            }

            .contact-form input:focus,
            .contact-form textarea:focus {
                  outline: none;
                  border-color: var(--primary-light);
                  background: var(--white);
                  box-shadow: 0 0 0 4px rgba(74, 124, 44, 0.1);
            }

            .contact-form button {
                  width: 100%;
                  padding: 1.2rem;
                  background: var(--primary);
                  color: white;
                  border: none;
                  border-radius: 12px;
                  font-size: 1rem;
                  font-weight: 700;
                  cursor: pointer;
                  transition: var(--transition);
                  letter-spacing: 0.5px;
            }

            .contact-form button:hover {
                  background: var(--primary-light);
                  box-shadow: 0 10px 20px rgba(45, 90, 39, 0.2);
            }

            /* Footer */
            .site-footer {
                  background: #1a2f0d;
                  color: rgba(255, 255, 255, 0.7);
                  padding: 4rem 0;
                  font-size: 0.9rem;
            }

            /* Responsive optimisé */
            @media (max-width: 768px) {
                  .main-nav {
                        display: none;
                        /* Cache le menu pour mobile, à remplacer par un burger plus tard */
                  }

                  .hero {
                        padding: 5rem 0;
                  }

                  .service-card {
                        padding: 2rem;
                  }
            }
      </style>
</head>

<body>
      <!-- Header -->
      <header class="site-header">
            <div class="container">
                  <div class="logo">
                        <h1>🌱 GreenTech Solutions</h1>
                  </div>
                  <nav class="main-nav">
                        <!-- Le menu WordPress sera inséré ici -->
                  </nav>
            </div>
      </header>

      <!-- Bandeau promotionnel (via hook) -->
      <div class="promo-banner">
            <!-- Contenu du hook after_header -->
      </div>

      <!-- Hero Section -->
      <section class="hero">
            <div class="container">
                  <div class="hero-content">
                        <h2>L'énergie verte pour votre entreprise</h2>
                        <p>Réduisez vos coûts énergétiques de 40% avec nos solutions écologiques sur-mesure</p>
                        <a href="#contact" class="cta-button">Demander un devis gratuit</a>
                  </div>
            </div>
      </section>

      <!-- Services Section -->
      <section class="services" id="services">
            <div class="container">
                  <h2>Nos Services</h2>
                  <div class="services-grid">
                        <div class="service-card">
                              <div class="service-icon">⚡</div>
                              <h3>Audit Énergétique</h3>
                              <p>Analyse complète de votre consommation pour identifier les économies potentielles</p>
                        </div>
                        <div class="service-card">
                              <div class="service-icon">☀️</div>
                              <h3>Panneaux Solaires</h3>
                              <p>Installation de panneaux photovoltaïques adaptés à vos besoins</p>
                        </div>
                        <div class="service-card">
                              <div class="service-icon">📊</div>
                              <h3>Optimisation</h3>
                              <p>Suivi et optimisation continue de votre consommation énergétique</p>
                        </div>
                  </div>
            </div>
      </section>

      <!-- Sidebar avec widget -->
      <aside class="sidebar-widget-area">
            <!-- Zone pour le widget "Nos derniers projets" -->
      </aside>

      <!-- Contact Section -->
      <section class="contact" id="contact">
            <div class="container">
                  <h2>Demandez votre devis gratuit</h2>
                  <div class="contact-form">
                        <!-- Formulaire du plugin sera inséré ici -->
                  </div>
            </div>
      </section>

      <!-- Footer -->
      <footer class="site-footer">
            <div class="container">
                  <p>&copy; 2026 GreenTech Solutions - Tous droits réservés</p>
            </div>
      </footer>
</body>

</html>