# m2-mediasync : documentation

Avant l'envoi du html, le parseur cherche tous les medias à télécharger par les expressions régulieres se trouvant dans le fichier "etc/config.xml" sous le noeud "default/dev/sga_mediasync/patterns"

## L'ajout de pattern depuis un autre module

Créer un fichier "<Vendor>/<Module>/etc/config.xml" et créer un noeud xml "default/dev/sga_mediasync/patterns/pXX" 