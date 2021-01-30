# m2-mediasync

Permet la synchronisation des fichiers media d'un environnement à partir d'un autre à la demande.

Avant l'envoi du html, le parseur cherche tous les medias à télécharger par les expressions régulieres se trouvant dans le fichier "etc/config.xml" sous le noeud "default/dev/sga_mediasync/patterns"

## Installation

Via composer

```bash
composer require sebgar/m2-mediasync
```