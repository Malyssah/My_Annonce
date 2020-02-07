# My_annonce - ApprentissagePHP

Projet "Fil Rouge" de la formation Développeur Web / Web Mobile Afpa 2019

<h2>Cahier des charges</h2>

<p>Le projet consiste à réaliser un système de gestion de petites annonces qui s’inspire des sites gratuits de petites annonces, et qui doit principalement permettre de consulter des annonces, d’en déposer, et de les gérer.<p>

<p>Une annonce est caractérisée au minimum par un en-tête, un corps et une date limite de validité, une rubrique et l’utilisateur qui l’a déposée. La gestion back-office est confiée à un administrateur de l’application. Pour certaines fonctionnalités, le système contrôle l’accès des utilisateurs.</p>

<h3>Catégorie d'utilisateurs: visiteur</h3>
<p>Tout visiteur du système d'annonces peut librement:</p>
  <ul>
    <li>consulter les annonces publiées,</li>
    <li>s’identifier ou créer un compte.</li>
  </ul>
  
<h3>Catégorie d'utilisateurs: utilisateur identifié</h3>
  <p>Tout utilisateur qui souhaite créer une annonce ou gérer ses annonces doit au préalable s'identifier.<p>
  <p>Les fonctionnalités accessibles à l’utilisateur identifié sont:<p>
    <ul>
      <li>déposer une annonce,</li>
      <li>gérer ses propres annonces:</li>
        <ul>
          <li>lister ses annonces,</li>
          <li>modifier une annonce,</li>
          <li>détruire une annonce.</li>
        </ul>
    </ul>
      
<h3>Catégorie d'utilisateurs: administrateur</h3>
<p>Tout administrateur a accès à des fonctions spécifiques lui permettant de :</p>
  <ul>
    <li>gérer les rubriques</li>
    <li>gérer les annonces périmées.</li>
  </ul>
