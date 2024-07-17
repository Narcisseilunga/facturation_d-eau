<!DOCTYPE html>
<html>
<head>
  <title>Système de Fourniture et de Facturation Automatique d'Eau</title>
  <style>
    /* Add your CSS styles here */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #007bff;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    main {
      padding: 20px;
    }
    section {
      margin-bottom: 40px;
    }
    h2 {
      color: #007bff;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <header>
    <h1>Système de Fourniture et de Facturation Automatique d'Eau</h1>
  </header>
  <main>
    <section>
      <h2>Membres du Groupe</h2>
      <table>
        <tr>
          <th>Nom</th>
          <th>Spécialité</th>
        </tr>
        <tr>
          <td>BASHIMBE TCHISHUGI DIEUDONNE</td>
          <td>MSI</td>
        </tr>
        <tr>
          <td>BUJIRIRI LINDA LAURENE</td>
          <td>MSI</td>
        </tr>
        <tr>
          <td>ISALA KAMINA TATIANA</td>
          <td>MSI</td>
        </tr>
        <tr>
          <td>ISESA FATUMA GLOIRE</td>
          <td>GL</td>
        </tr>
        <tr>
          <td>ILUNGA KASANI NARCISSE</td>
          <td>GL</td>
        </tr>
        <tr>
          <td>KABWIT MUJING BENITA</td>
          <td>GL</td>
        </tr>
        <tr>
          <td>KUNDA KEFE CHANCELLE</td>
          <td>MSI</td>
        </tr>
        <tr>
          <td>KYUNGU BANZE RITA</td>
          <td>MSI</td>
        </tr>
        <tr>
          <td>NTAMBWE MUKONKOLE HAMMIELL</td>
          <td>MSI</td>
        </tr>
        <tr>
          <td>TSHITEYA NDAYA YVES</td>
          <td>MSI</td>
        </tr>
      </table>
    </section>
    <section>
      <h2>Résumé du Projet</h2>
      <p>Notre projet consiste à concevoir un système innovant de fourniture et de facturation automatique d'eau visant à optimiser la distribution de l'eau potable et à simplifier le processus de facturation pour les résidents.</p>
    </section>
    <section>
      <h2>Introduction</h2>
      <p>L'accès à une fourniture en eau fiable et un processus de facturation efficace sont des éléments essentiels pour le bon fonctionnement d'une ville. Les problèmes à résoudre sont le gaspillage d'eau, la surconsommation d'eau et une facturation qui n'est pas précise et équitable.</p>
    </section>
    <section>
      <h2>Matériels Utilisés</h2>
      <ul>
        <li>Capteurs de débit (Flow Sensors) : Capteur de débit YF-S201</li>
        <li>Carte Arduino</li>
        <li>Module de communication : Module Wi-Fi (ESP8266 ou ESP32) pour la connectivité Internet</li>
        <li>Alimentation électrique : Batterie rechargeable pour les installations autonomes</li>
        <li>Câblage et fil de connexion</li>
        <li>Capteur d'humidité</li>
      </ul>
    </section>
    <section>
      <h2>Schéma et Diagramme Explicatif</h2>
      <h3>Diagramme de Cas d'Utilisation</h3>
      <img src="img/casdutil.JPG" alt="Diagramme de Cas d'Utilisation">
      <h3>Diagrammes de Séquence</h3>
      <h4>Scénario : S'inscrire</h4>
      <img src="./img/diagramme_sec.JPG" alt="Diagramme de Séquence - S'inscrire">
      <h4>Scénario : S'authentifier</h4>
      <img src="./img/s\'authentifier.JPG" alt="Diagramme de Séquence - S'authentifier">
      <h4>Scénario : Détecter Fuites</h4>
      <img src="./img/detectfuite.JPG" alt="Diagramme de Séquence - Détecter Fuites">
      <h4>Scénario : Gérer Historique</h4>
      <img src="./stockerhistorique.JPG" alt="Diagramme de Séquence - Gérer Historique">
      <h4>Scénario : Envoyer Alertes</h4>
      <img src="./img/envoyerdesalertes.JPG" alt="Diagramme de Séquence - Envoyer Alertes">
      <h4>Scénario : Envoyer et Recevoir des Notifications</h4>
      <img src="./img/notif.JPG" alt="Diagramme de Séquence - Envoyer et Recevoir des Notifications">
      <h3>Diagramme d'Activité</h3>
      <img src="./img/diagrammeActivite.JPG" alt="Diagramme d'Activité">
    </section>
    <section>
      <h2>Étapes du Développement</h2>
      <p>Les principales difficultés rencontrées lors du développement sont :</p>
      <ul>
        <li>Intégration des différents composants (capteurs, modules de communication, etc.)</li>
        <li>Développement de l'interface utilisateur conviviale</li>
        <li>Implémentation des algorithmes de détection de fuites et de facturation automatique</li>
      </ul>
    </section>
    <section>
      <h2>Résultat</h2>
      <p>Le système de fourniture et de facturation automatique d'eau développé permet d'optimiser la distribution de l'eau potable et de simplifier le processus de facturation pour les résidents de la ville. Les principaux résultats obtenus sont :</p>
      <ul>
        <li>Réduction du gaspillage d'eau grâce à la détection rapide des fuites</li>
        <li>Facturation précise et équitable basée sur la consommation réelle de chaque utilisateur</li>
        <li>Amélioration de la satisfaction des résidents avec un service plus fiable et transparent</li>
      </ul>
    </section>
    <section>
      <h2>Références</h2>
      <p>Voici les principales références utilisées pour ce projet :</p>
      <ul>
        <li>Documentation technique des composants électroniques (capteurs, modules de communication, etc.)</li>
        <li>Ressources en ligne sur la conception de systèmes IoT pour la gestion de l'eau</li>
        <li>Études de cas et bonnes pratiques dans le domaine de la fourniture et de la facturation automatique d'eau</li>
      </ul>
    </section>
  </main>
</body>
</html>
