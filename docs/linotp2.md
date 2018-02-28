Original copyright:

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

# LinOTP2 module

This module provides an authentication module for simpleSAMLphp to talk to LinOTP2. It can be implemented in two ways.

## As an authsource

`linotp2:linotp2`
: Authenticate a user against a LinOTP2 server.

This module contacts the LinOTP2 server via the API (https://linotp2server/validate/check) and authenticates the user according to the token assigned to the user.

The response can also contain some attributes.

To enable this module add the authentication source 'linotp2:linotp2' to 'config/authsources.php'. Do it like this:

```
    'example-linotp2' => array(
        'linotp2:linotp2',

        /*
         * The name of the LinOTP server and the protocol
	     * A port can be added by a :
         * Required.
         */
        'linotpserver' => 'https://your.server.com',

        /*
         * Check if the hostname matches the name in the certificate
         * Optional.
         */
        'sslverifyhost' => False,

        /*
         * Check if the certificate is valid, signed by a trusted CA
         * Optional.
         */
        'sslverifypeer' => False,

        /*
         * The realm where the user is located in.
         * Optional.
         */
        'realm' => '',

        /*
         * This is the translation from LinOTP attribute names to
         * SAML attribute names. If given, the LinOTP attribute name
         * will be renamed accordingly
         * Optional
         */
         'attributemap' => array(
         				'username' => 'samlLoginName',
         				'surname' => 'surName',
         				'givenname' => 'givenName',
         				'email' => 'emailAddress',
         				'phone' => 'telePhone',
         				'mobile' => 'mobilePhone',
         				),

    ),
```

## As an authproc filter

The functionality added by [Code Enigma](https://www.codeenigma.com) is an auth processing filter, which can add an optional step into your authentication process to provide an additional authentication check (2FA). We typically use this with an LDAP login followed by a OTP token check, however it can be combined with any other auth sources to provide an additional check.

To use this filter, add something like this into the `authproc.idp` array in `config/config.php` - note, in this example we are logging into AWS, so the username attribute we use to check the token against LinOTP is 'https://aws.amazon.com/SAML/Attributes/RoleSessionName' - you'll need to know what attribute the username you need to pass to LinOTP is contained within and adjust accordingly:

```
    'authproc.idp' => array(
        55 => array(
            'class' => 'linotp2:OTP',

            /*
             * The name of the LinOTP server and the protocol
             * A port can be added by a :
             * Required.
             */
            'linotpserver' => 'https://2fa.codeenigma.net',


           /*
            * The attribute we should use in the $state['Attributes']
            * array to look up the LinOTP username (defaults to LDAP
            * attribute 'uid').
            */
           'linotpuidattribute' => 'https://aws.amazon.com/SAML/Attributes/RoleSessionName',

            /*
             * Check if the hostname matches the name in the certificate
             * Optional.
             */
            'sslverifyhost' => True,

            /*
             * Check if the certificate is valid, signed by a trusted CA
             * Optional.
             */
            'sslverifypeer' => True,

            /*
             * The realm where the user is located in.
             * Optional.
             */
            'realm' => '',
	    
            /*
             * This is the translation from LinOTP attribute names to
             * SAML attribute names. If given, the LinOTP attribute name
             * will be renamed accordingly
             * Optional
             */
             'attributemap' => array(
                 'username' => 'samlLoginName',
                 'surname' => 'surName',
                 'givenname' => 'givenName',
                 'email' => 'emailAddress',
                 'phone' => 'telePhone',
                 'mobile' => 'mobilePhone',
             ),
        ),

    ),

```

## Optional extra, filtering users for an SP

You can also filter who can access an SP to a subset of usernames within your SP metadata array like so:

```
  'authproc' => array(

    90 => array(
        'class' => 'authorize:Authorize',
        'https://aws.amazon.com/SAML/Attributes/RoleSessionName'   =>  array(
            '/(bob|jim|sarah|angie)/',
        ),
    ),
  ),
```

Note, the attribute name must match that which contains the username for LinOTP, as mentioned above.
