## PgMetadata Module

This module is designed for Lizmap Web Client, and allows to display PostgreSQL layers metadata stored in the layer database.

The metadata must be created in the PostgreSQL database as designed in the [PgMetadata QGIS plugin](https://github.com/3liz/qgis-pgmetadata-plugin).

![Metadata information panel](metadata_information_panel.jpeg)

### Installation

Once Lizmap Web Client application is installed and working, you can install the pgmetadata module:

* Get the last ZIP archive in the [release page](https://github.com/3liz/lizmap-pgmetadata-module/releases) of the github repository.
* Extract the archive and copy the `pgmetadata` directory in Lizmap Web Client folder `lizmap/lizmap-modules/`
* Edit the config file `lizmap/var/config/localconfig.ini.php` and add (or adapt) the section `[modules]` by adding the `pgmetadata.access=2`

```ini
[modules]
pgmetadata.access=2
```

* Run Lizmap Web Client installer

```bash
php lizmap/install/installer.php
lizmap/install/clean_vartmp.sh
lizmap/install/set_rights.sh
```

## Contribution guide

For PHP, the project is using PHP-CS-Fixer.
For JavaScript, it's using ESLint. Install it using `npm install`.

There are commands in the Makefile to run them.
