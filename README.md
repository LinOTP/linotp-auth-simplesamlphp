# LinOTP2 SimpleSAMLphp integration

This module is forked from this project by Key Identity:
https://github.com/LinOTP/linotp-auth-simplesamlphp

Original copyright information:

```
    linotp-auth-simplesamlphp - LinOTP SimpleSAMLphp plugin
    Copyright (C) 2010 - 2017 KeyIdentity GmbH

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

     E-mail: linotp@keyidentity.com
     Contact: www.linotp.org
     Support: www.keyidentity.com
```


This is an authentication module for simpleSAMLphp to authenticate against [LinOTP](http://www.linotp.org).

## Installation

First you need to get [SimpleSAMLphp](http://simplesamlphp.org). If you installed SimpleSAMLphp using composer, you may simply add this to your root `copmposer.json` file:

```
    "repositories": [
        {
            "url": "git@github.com:codeenigma/linotp2.git",
            "type": "git"
        }
    ],
    "require": {
        "codeenigma/simplesamlphp-module-linotp2": "dev-master"
    },
```

Then run `composer update`.

If you installed SimpleSAMLphp in another way (downloaded package, other repository, etc.) then you can [download the zip](https://github.com/codeenigma/linotp2/archive/master.zip) of this module and copy it into the `modules` directory of SimpleSAMLphp.

## Operation

See this txt file for more detailed configuration:
https://github.com/codeenigma/linotp2/blob/master/docs/linotp2.txt
