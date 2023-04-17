# SIGA (SISTEMA DE GESTION DE AUSENTISMOS)

Proyecto de gestión de ausentismos, en la División de Gestión del Talento Humano. Este se desarrolla con PHP, JavaScript. Práctica de Estado Joven 2022-2.

Este proyecto proporciona una interfaz web para gestionar y visualizar datos de ausentismos en forma gráfica y tabular, con la capacidad de filtrar y descargar resultados en formato Excel. Utiliza un entorno de desarrollo local con XAMPP y una base de datos MySQL.

## Características

- Registro y gestión de ausentismos en un entorno web.
- Visualización de datos en forma gráfica para un análisis intuitivo.
- Búsqueda de registros utilizando filtros como fecha, tipo de ausentismo, y más.
- Descarga de resultados de búsqueda en formato Excel para un procesamiento adicional.
- Integración con PHP, JavaScript, MySQL y Apache.
- Interfaz de usuario intuitiva y fácil de usar.

<div align="center">
  <img src="assets/dashboard.png" alt="Dashboard" width="700px" height="auto">
</div>



## Requisitos del sistema

- PHP 8.1.6
- MySQL 10.4.24 MariaDB
- Apache 2.4.53
- XAMPP o similar para el entorno de desarrollo local

## Cómo comenzar

1. Clonar este repositorio en tu entorno local.
2. Configurar el entorno de desarrollo local con XAMPP o similar.
3. Importar la base de datos proporcionada en MySQL.
4. Configurar la conexión a la base de datos en el código fuente.
5. Acceder a la interfaz web del proyecto en tu navegador.
6. Utilizar las funcionalidades de registro, visualización y búsqueda de ausentismos.
7. Descargar los resultados de búsqueda en formato Excel según sea necesario.

<!--## Contribuciones

Las contribuciones son bienvenidas! Si deseas contribuir a este proyecto, por favor sigue los siguientes pasos:

1. Haz un fork de este repositorio.
2. Crea una rama con un nombre descriptivo.
3. Realiza tus modificaciones y mejoras.
4. Haz un pull request a la rama principal de desarrollo.
5. Tu contribución será revisada y fusionada si es apropiada. -->

## Licencia

Este proyecto se encuentra bajo la Licencia [MIT](LICENSE), lo cual significa que puedes usar, copiar, modificar, fusionar, publicar, distribuir, sublicenciar y/o vender copias del software, bajo ciertas condiciones. Consulta el archivo de licencia para más detalles.

<!-- Espero que esto te ayude a mejorar tu README.md para tu proyecto SIGA. ¡Buena suerte con tu proyecto! -->


<!-- DigitalOcean: http://137.184.203.51/  -->


<div align="center">
    <a href="https://php.net">
        <img
            alt="PHP"
            src="https://www.php.net/images/logos/new-php-logo.svg"
            width="150">
    </a>
</div>

# The PHP Interpreter

PHP is a popular general-purpose scripting language that is especially suited to
web development. Fast, flexible and pragmatic, PHP powers everything from your
blog to the most popular websites in the world. PHP is distributed under the
[PHP License v3.01](LICENSE).

[![Push](https://github.com/php/php-src/actions/workflows/push.yml/badge.svg)](https://github.com/php/php-src/actions/workflows/push.yml)
[![Build status](https://travis-ci.com/php/php-src.svg?branch=master)](https://travis-ci.com/github/php/php-src)
[![Build status](https://ci.appveyor.com/api/projects/status/meyur6fviaxgdwdy/branch/master?svg=true)](https://ci.appveyor.com/project/php/php-src)
[![Build Status](https://dev.azure.com/phpazuredevops/php/_apis/build/status/php.php-src?branchName=master)](https://dev.azure.com/phpazuredevops/php/_build/latest?definitionId=1&branchName=master)
[![Fuzzing Status](https://oss-fuzz-build-logs.storage.googleapis.com/badges/php.svg)](https://bugs.chromium.org/p/oss-fuzz/issues/list?sort=-opened&can=1&q=proj:php)

## Documentation

The PHP manual is available at [php.net/docs](https://php.net/docs).

## Installation

### Prebuilt packages and binaries

Prebuilt packages and binaries can be used to get up and running fast with PHP.

For Windows, the PHP binaries can be obtained from
[windows.php.net](https://windows.php.net). After extracting the archive the
`*.exe` files are ready to use.

For other systems, see the [installation chapter](https://php.net/install).

### Building PHP source code

*For Windows, see [Build your own PHP on Windows](https://wiki.php.net/internals/windows/stepbystepbuild_sdk_2).*

For a minimal PHP build from Git, you will need autoconf, bison, and re2c. For
a default build, you will additionally need libxml2 and libsqlite3.

On Ubuntu, you can install these using:

    sudo apt install -y pkg-config build-essential autoconf bison re2c \
                        libxml2-dev libsqlite3-dev

On Fedora, you can install these using:

    sudo dnf install re2c bison autoconf make libtool ccache libxml2-devel sqlite-devel

Generate configure:

    ./buildconf

Configure your build. `--enable-debug` is recommended for development, see
`./configure --help` for a full list of options.

    # For development
    ./configure --enable-debug
    # For production
    ./configure

Build PHP. To speed up the build, specify the maximum number of jobs using `-j`:

    make -j4

The number of jobs should usually match the number of available cores, which
can be determined using `nproc`.

## Testing PHP source code

PHP ships with an extensive test suite, the command `make test` is used after
successful compilation of the sources to run this test suite.

It is possible to run tests using multiple cores by setting `-jN` in
`TEST_PHP_ARGS`:

    make TEST_PHP_ARGS=-j4 test

Shall run `make test` with a maximum of 4 concurrent jobs: Generally the maximum
number of jobs should not exceed the number of cores available.

The [qa.php.net](https://qa.php.net) site provides more detailed info about
testing and quality assurance.

## Installing PHP built from source

After a successful build (and test), PHP may be installed with:

    make install

Depending on your permissions and prefix, `make install` may need super user
permissions.

## PHP extensions

Extensions provide additional functionality on top of PHP. PHP consists of many
essential bundled extensions. Additional extensions can be found in the PHP
Extension Community Library - [PECL](https://pecl.php.net).

## Contributing

The PHP source code is located in the Git repository at
[github.com/php/php-src](https://github.com/php/php-src). Contributions are most
welcome by forking the repository and sending a pull request.

Discussions are done on GitHub, but depending on the topic can also be relayed
to the official PHP developer mailing list internals@lists.php.net.

New features require an RFC and must be accepted by the developers. See
[Request for comments - RFC](https://wiki.php.net/rfc) and
[Voting on PHP features](https://wiki.php.net/rfc/voting) for more information
on the process.

Bug fixes don't require an RFC. If the bug has a GitHub issue, reference it in
the commit message using `GH-NNNNNN`. Use `#NNNNNN` for tickets in the old
[bugs.php.net](https://bugs.php.net) bug tracker.

    Fix GH-7815: php_uname doesn't recognise latest Windows versions
    Fix #55371: get_magic_quotes_gpc() throws deprecation warning

See [Git workflow](https://wiki.php.net/vcs/gitworkflow) for details on how pull
requests are merged.

### Guidelines for contributors

See further documents in the repository for more information on how to
contribute:

- [Contributing to PHP](/CONTRIBUTING.md)
- [PHP coding standards](/CODING_STANDARDS.md)
- [Mailing list rules](/docs/mailinglist-rules.md)
- [PHP release process](/docs/release-process.md)

## Credits

For the list of people who've put work into PHP, please see the
[PHP credits page](https://php.net/credits.php).
