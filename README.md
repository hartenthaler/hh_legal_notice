# webtrees module hh_legal_notice

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0)

![webtrees major version](https://img.shields.io/badge/webtrees-v2.1.x-green) ![webtrees major version](https://img.shields.io/badge/webtrees-v2.2.x-green)

![Latest Release](https://img.shields.io/github/v/release/hartenthaler/hh_legal_notice)

This [webtrees](https://www.webtrees.net) module creates a legal notice in the footer of the web page.

Disclaimer: This is not a legal advice. You as administrator of your website are responsible for the content of the Legal Notice on your site.

There is a German [manual page](https://wiki.genealogy.net/Webtrees_Handbuch/Anleitung_f%C3%BCr_Webmaster/Erweiterungsmodule/Legal_Notice) available, too.

<a name="Contents"></a>
## Contents

This Readme contains the following main sections

* [Description](#description)
* [Screenshots](#screenshots)
* [webtrees](#webtrees)
* [Requirements](#requirements)
* [Installation](#installation)
* [Upgrade](#upgrade)
* [Contributing](#contributing)
* [Translation](#translation)
* [Contact Support](#support)
* [License](#license)

<a name="description"></a>
## Description

This module adds a legal notice footer to all pages of a webtrees site.

There is maybe a need to present on your website a "Legal Notice"
(depending on your local law and the character of your site)
* Germany: [§5 Digitale-Dienste-Gesetz (DDG)](https://lxgesetze.de/ddg/5), 
and [§4 Medienstaatsvertrag (MStV)](https://lxgesetze.de/mstv/4)
* Austria: § 5 Abs. 1 E-Commerce-Gesetz (ECG)
* Switzerland: Art. 3 des Bundesgesetzes gegen den unlauteren Wettbewerb (UWG)

The webtrees admin can define the following data fields in the control panel for the responsible person
* name of responsible person
* name of genealogical club or organization
* address
* phone and fax numbers
* eMail address (with or without subject and body of eMail)
* VAT ID number or other registration number (like a club registration number)

The webtrees admin can choose if the following additional parts should be shown
* copyright notice in the footer
* image of the responsible person using the [Gravatar](https://gravatar.com/)
* list of contact persons for a tree (genealogical and technical)
* list of administrators of this site with their contact links
* chapter about "Legal Regulations" with several sections

Those sections can be reordered and individually enabled or disabled.
There are two styles provided for those sections: "I" style and "We" style,
depending on the number of website administrators.

The chapter "Datenschutzerklärung" is a first draft.
It is only available in German.
The administrator can enable or disable this chapter, but the sequence cannot be chosen at the moment.
It is intended to add more content to this chapter
and to make the content translatable.

<a name="screenshots"></a>
## Screenshots

Screenshot of Legal Notice footer (in German language)
<p align="center"><img src="docs/img/legal_notice_footer.png" alt="Screenshot of Legal Notice" align="center" width="60%"></p>

Screenshot of Legal Notice (in German language)
<p align="center"><img src="docs/img/legal_notice.png" alt="Screenshot of Legal Notice" align="center" width="80%"></p>

Screenshot of control panel page (in German language)
<p align="center"><img src="docs/img/legal_notice_control_panel.png" alt="Screenshot of control panel menu" align="center" width="80%"></p>

<a name="webtrees"></a>
## webtrees

**[webtrees](https://webtrees.net/)** is an online collaborative genealogy application.
This can be hosted on your own server by following the [Install instructions](https://webtrees.net/install/).
If you are familiar with Docker, you might like to install **webtrees** using [this unofficial docker image](https://hub.docker.com/r/nathanvaughn/webtrees), or any other one.

<a name="requirements"></a>
## Requirements

This module requires **webtrees** version 2.1 or 2.2.
This module has the same requirements as [webtrees#system-requirements](https://github.com/fisharebest/webtrees#system-requirements).

This module was tested with **webtrees** versions 2.1.22 and 2.2.1
and all available themes and all other custom modules.

<a name="installation"></a>
## Installation

This section documents installation instructions for this module.

1. Make a database backup
2. Download the [latest release](https://github.com/hartenthaler/hh_legal_notice/releases/latest).
3. Unzip the package into your `webtrees/modules_v4` directory of your web server.
4. Rename the folder to `hh_legal_notice`.
5. Login to **webtrees** as administrator, go to <span class="pointer">Control Panel/Modules/Website/Footers</span>, and find the module. It will be called "Legal Notice and Privacy Policy". Check if it has a tick for "Enabled".
6. Click at the wrench symbol and add all desired information fields.
7. Maybe you like to deactivate the module "contact information" (depending whether you have activated this in the "Legal Notice" module).
8. Finally, click SAVE, to complete the installation.

<a name="upgrade"></a>
## Upgrade

To update simply replace the `hh_legal_notice` files
with the new ones from the latest release.

### Upgrading from the former hh_imprint module
+ Do NOT delete the module settings of the former `hh_imprint` module before the installation of `hh_legal_notice`.
+ Delete the folder `hh_imprint`in your `webtrees/modules_v4` directory.
+ Install the `hh_legal_notice` module like described in chapter [Installation](#installation).
+ Open the Control Panel of this footer module; `hh_legal_notice` will takeover the existing settings from `hh_imprint`.
+ You should see a notice. Click on "save". Now you should see all settings. Modify them and save them again.
+ After `hh_legal_notice` has migrated the settings, the old settings of `hh_imprint` can be removed (follow the message in the control panel after deletion of the module).

<a name="contributing"></a>
## Contributing

If you'd like to contribute to this module, great! You can contribute by

- Reading and commenting the legal chapters carefully - choose a specific topic and please [create an issue](https://github.com/hartenthaler/hh_legal_notice/issues) for that topic.
- Contributing code - check out the issues for things that need attention. If you have changes you want to make not listed in an issue, please create one, then you can link your pull request.
- Testing - it's all manual currently, please [create an issue](https://github.com/hartenthaler/hh_legal_notice/issues) for any bugs you find.

<a name="translation"></a>
## Translation

You can use a local editor,
like Poedit or Notepad++ to make the translations and send them back to me.
You can do this via a pull request (if you know how) or by e-mail.

Discussion on translating can be done by creating an [issue](https://github.com/hartenthaler/hh_legal_notice/issues).

Updated translations will be included in the next release of this module.

There are now, beside English the following languages available
- Dutch (by TheDutchJewel)
- Catalan (by Bernat Josep Banyuls i Sala)
- German (by Hermann Hartenthaler)

The [PO Editor project](https://poeditor.com/join/project/zscMiujN1m) is not supported any longer (costs too high).

<a name="support"></a>
## Support

**Issues**: for any ideas you have, or when finding a bug you can raise an [issue](https://github.com/hartenthaler/hh_legal_notice/issues).

**Forum**: general webtrees support can be found at the [webtrees forum](http://www.webtrees.net/).

<a name="license"></a>
## License

* Copyright (C) 2025 Hermann Hartenthaler
* Derived from **webtrees** - Copyright 2025 webtrees development team.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

* * *