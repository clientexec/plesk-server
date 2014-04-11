<?php

require_once dirname(__FILE__).'/class.pleskserver.php';
require_once 'modules/admin/models/ServerPlugin.php';
/**
* @package Plugins
*/
class PluginPlesk extends ServerPlugin
{
  public $features = array(
        'packageName' => true,
        'testConnection' => false,
        'showNameservers' => true
    );

    function getVariables()
    {
        /* Specification
              itemkey     - used to identify variable in your other functions
              type        - text,textarea,yesno,password,hidden ( type hidden are variables used by CE and are required )
              description - description of the variable, displayed in ClientExec
              encryptable - used to indicate the variable's value must be encrypted in the database
              template    - used to indicate the variable is in the domain template
        */

        $variables = array(
            /*T*/'Name'/*/T*/          => array(
                'type'          => 'hidden',
                'description'   => 'Used By CE to show plugin - must match how you call the action function names',
                'value'         => 'Plesk',
                               ),
            /*T*/'Description'/*/T*/   => array(
                'type'          => 'hidden',
                'description'   => /*T*/'Description viewable by admin in server settings'/*/T*/,
                'value'         => /*T*/'Plesk control panel integration'/*/T*/,
                               ),
            /*T*/'Username'/*/T*/      => array(
                'type'          => 'text',
                'description'   => /*T*/'If you\'ll provide reseller accounts, enter here the Plesk administrator credentials. Otherwise just enter a regular user\'s credentials, but be aware that such user has to have \'Domain creation\', \'Physical hosting management\', \'Hard disk quota assignment\', \'Domain limits adjustment\'  and \'Ability to use remote XML interface\' permissions. This user will also need to have all its personal data configured in Plesk (E-mail, phone, etc), even those fields that are not marked as required.'/*/T*/,
                'value'         => '',
                               ),
            /*T*/'Password'/*/T*/      => array(
                'type'          => 'password',
                'description'   => /*T*/'If you\'ll provide reseller accounts, enter here the Plesk administrator credentials. Otherwise just enter a regular user\'s credentials, but be aware that such user has to have \'Domain creation\', \'Physical hosting management\', \'Hard disk quota assignment\', \'Domain limits adjustment\'  and \'Ability to use remote XML interface\' permissions. This user will also need to have all its personal data configured in Plesk (E-mail, phone, etc), even those fields that are not marked as required.'/*/T*/,
                'value'         => '',
                'encryptable'   => true,
                               ),
            /*T*/'Non-Admin Username'/*/T*/ => array(
                'type'          => 'text',
                'description'   => /*T*/'If you\'ll provide both reseller and non-reseller accounts, use the Plesk administrator account to create a user under whom non-reseller accounts (domains) will be created and enter its credentials here. Otherwise leave this field empty. This user will also need to have all its personal data configured in Plesk (E-mail, phone, etc), even those fields that are not marked as required.'/*/T*/,
                'value'         => '',
                               ),
            /*T*/'Non-Admin Password'/*/T*/ => array(
                'type'          => 'password',
                'description'   => /*T*/'If you\'ll provide both reseller and non-reseller accounts, use the Plesk administrator account to create a user under whom non-reseller accounts (domains) will be created and enter its credentials here. Otherwise leave this field empty. This user will also need to have all its personal data configured in Plesk (E-mail, phone, etc), even those fields that are not marked as required.'/*/T*/,
                'value'         => '',
                'encryptable'   => true,
                               ),
            /*T*/'Actions'/*/T*/       => array(
                'type'          => 'hidden',
                'description'   => /*T*/'Current actions that are active for this plugin per server'/*/T*/,
                'value'         => 'Create,Delete,Suspend,UnSuspend',
                               ),
            /*T*/'package_vars'/*/T*/  => array(
                'type'          => 'hidden',
                'description'   => /*T*/'Whether package settings are set'/*/T*/,
                'value'         => '0',
                               ),
            /*T*/'package_vars_values'/*/T*/ => array(
                'type'          => 'hidden',
                'description'   => /*T*/'Hosting account parameters'/*/T*/,
                'value'         => array(
                                        'reseller_account' => array(
                                                               'type'           => 'check',
                                                               'label'          =>'Reseller Account',
                                                               'description'    => /*T*/'You need Plesk Administrator access.<br>NOTE: The username for non-reseller accounts is the domain name'/*/T*/,
                                                               'value'          => '0',
                                                           ),
                                        'max_dom'       => array(
                                                               'type'           => 'text',
                                                                'label'          =>'Maximum number of domains',
                                                               'description'    => /*T*/'For resellers only, leave empty for unlimited'/*/T*/,
                                                               'value'          => '',
                                                            ),
                                        'www'           => array(
                                                               'type'           => 'check',
                                                               'label'    => /*T*/'Use www prefix'/*/T*/,
                                                               'value'          => '1',
                                                            ),
                                        'max_subdom'    => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of subdomains (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'disk_space'    => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Disk space (in bytes, leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_traffic'   => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum amount of traffic (in bytes/month, leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_wu'        => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of web users (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_db'        => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of databases (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_box'       => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of mailboxes (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'mbox_quota'    => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Mailbox quota (in bytes, leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_redir'     => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of mail redirects (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_mg'        => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of mail groups (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_resp'      => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of mail autoresponders (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_maillists' => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of mail lists (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'max_webapps'   => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of Java applications (leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'ftp_quota'     => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'FTP quota (in bytes, leave empty for unlimited)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'fp'            => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'FrontPage support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'fp_ssl'        => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'FrontPage over SSL support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'fp_auth'       => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'Allow FrontPage Authorization'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'ssl'           => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'SSL support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'shell'         => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'System shell (e.g. /bin/bash. Leave empty to disallow)'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'php'           => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'PHP support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'ssi'           => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'SSI support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'cgi'           => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'CGI support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'mod_perl'      => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'mod_perl support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'mod_python'    => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'mod_python support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'asp'           => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'Apache ASP support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'asp_dot_net'   => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'ASP.NET support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'max_mssql_db'   => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Maximum number of Microsoft SQL Server databases'/*/T*/,
                                                               'value'          => '',
                                                               'template'       => true,
                                                            ),
                                        'coldfusion'    => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'Coldfusion support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'webstat'       => array(
                                                               'type'           => 'text',
                                                               'description'    => /*T*/'Webserver statistics support (awstats, webalizer, smarterstats, urchin, none)'/*/T*/,
                                                               'value'          => 'none',
                                                               'template'       => true,
                                                            ),
                                        'errdocs'       => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'Custom error documents support'/*/T*/,
                                                               'value'          => '0',
                                                               'template'       => true,
                                                            ),
                                        'at_domains'    => array(
                                                               'type'           => 'check',
                                                               'description'    => /*T*/'@-domains support'/*/T*/,
                                                               'value'          => '0',
                                                            ),
                                    ),
                ),
            /*T*/'package_addons'/*/T*/ => array(
                'type'          => 'hidden',
                'description'   => /*T*/'Supported signup addons variables'/*/T*/,
                'value'         => array(
                    'DISKSPACE', 'BANDWIDTH', 'EMAIL_ACCOUNTS', 'EMAIL_QUOTA', 'SSH_ACCESS', 'SSL'
                ),
            ),
        );

        return $variables;
    }

    function validateCredentials($args)
    {
        $errors = array();
        if (!preg_match('/^[\w.-]+$/',$args['package']['username'])) {
            $errors[] = /*T*/'Domain username can only contain alphanumeric characters, dots, dashes and underscores'/*/T*/;
        }

        if (strpos($args['package']['password'],$args['package']['username']) !== false) {
            $errors[] = /*T*/'Domain password can\'t contain domain username'/*/T*/;
        }

        if (trim($args['package']['username']) == '') {
            $errors[] = /*T*/'Domain username can\'t be empty'/*/T*/;
        }

        if (strlen($args['package']['password']) > 14 && @$args['generateNewUsername']) {
            $args['package']['password'] = mb_substr($args['package']['password'], 0, 14);
        }

        if (strlen($args['package']['password']) < 5 || strlen($args['package']['password']) > 14) {
            $errors[] = /*T*/'Password length must be between 5 and 14 characters'/*/T*/;
        }

        // Plesk only allows lower case user names
        $args['package']['username'] = strtolower($args['package']['username']);

        if(isset($args['noError'])) {
            return $args['package']['username'];
        } else {
            if (count($errors) > 0) {
                throw new CE_Exception($errors[0]);
            }
        }

        return $args['package']['username'];
    }

    function create($args)
    {
        // package add-ons handling
        if (isset($args['package']['addons']['DISKSPACE'])) {
            $args['package_vars']['disk_space'] += ((int)$args['package']['addons']['DISKSPACE']) * 1048576; // 1 Meg in bytes
        }
        if (isset($args['package']['addons']['BANDWIDTH'])) {
            $args['package_vars']['max_traffic'] += ((int)$args['package']['addons']['BANDWIDTH']) * 1073741824; // 1 Gig in bytes
        }
        if (isset($args['package']['addons']['EMAIL_ACCOUNTS'])) {
            $args['package_vars']['max_box'] += ((int)$args['package']['addons']['EMAIL_ACCOUNTS']);
        }
        if (isset($args['package']['addons']['EMAIL_QUOTA'])) {
            $args['package_vars']['mbox_quota'] += ((int)$args['package']['addons']['EMAIL_QUOTA']) * 1048576;
        }
        if (isset($args['package']['addons']['SSH_ACCESS']) && $args['package']['addons']['SSH_ACCESS'] == 1) {
            $args['package_vars']['shell'] = '/bin/bash';
        }
        if (isset($args['package']['addons']['SSL']) && $args['package']['addons']['SSL'] == 1) {
            $args['package_vars']['ssl'] = '1';
        }

        if (isset($args['package_vars']['reseller_account']) && $args['package_vars']['reseller_account'] == 1) {
            // use $server to test with mock object
           $server = $this->getServer($args);

            // create user in Plesk
            $tUser = new User($args['customer']['id']);
            $userId = $server->addUser( $args['customer']['first_name'] . ' ' . $args['customer']['last_name'] . ' (' . $args['package']['id'] . ')',
                                        $args['package']['username'],
                                        $args['package']['password'],
                                        $tUser);
            if (is_a($userId, 'CE_Error')) {
                return $userId;
            }
            $response = $server->addResellerPermissionsAndLimits($userId, @$args['package_vars']);
            if (is_a($response, 'CE_Error')) {
                return $response;
            }


        } else {
            if (!$server) {
               $server = $this->getServer($args);
            }
            $userId = false;
        }

        // add domain to user
        if($args['package']['name_on_server']!=null && $args['package']['name_on_server']!= ''){
            $args['package_vars']['PackageNameOnServer'] = $args['package']['name_on_server'];
            $variables = $this->getVariables();
            foreach($variables['package_vars_values']['value'] AS $varName=>$attrs){
                if(isset($attrs['template']) && $attrs['template']){
                    $args['package_vars']['TemplateAttr'][] = $varName;
                }
            }
        }
        $tUser = new User($args['customer']['id']);
        $userId = $server->addUser( $args['customer']['first_name'] . ' ' . $args['customer']['last_name'] . ' (' . $args['package']['id'] . ')',
                                        $args['package']['username'],
                                        $args['package']['password'],
                                        $tUser);

        if (is_a($result = $server->addIpToUser($userId, $args['package']['ip']), 'CE_Error')) {
                return $result;
            }

        $domainId = $server->addDomainToUser(    $userId,
                                                 $args['package']['username'],
                                                 $args['package']['password'],
                                                 $args['package']['domain_name'],
                                                 $args['package']['ip'],
                                                 @$args['package_vars'],
                                                 $tUser
                                                 );

        // Ignore error 2307: always raises even if operation was successful.
        if (is_a($domainId, 'CE_Error') && $domainId->getErrCode() != 2307) {
            $errormsg = 'There was an error creating the domain. ERROR CODE '.$domainId->getErrCode().'. '.$domainId->getMessage();
            CE_Lib::log(4, "plugin_plesk::create::error: ".$errormsg);

            throw new CE_Exception($errormsg, 200);
        }

        return array('userId' => $userId, 'domainId' => $domainId);

    }

    // use $server to test with mock object
    function update($args)
    {
        $userName       = '';
        $password       = '';
        $ip             = $args['package']['ip'];
        $packageVars    = false;

        foreach ( $args['changes'] as $change => $newValue )
        {
            switch($change)
            {
                case 'username':
                    $userName = $newValue;
                    break;
                case 'password':
                    $password = $newValue;
                    break;
                case 'package':
                    $package = $newValue;
                    break;
                case 'ip':
                    $ip = $newValue;
                    break;
            }
        }
        if (isset($args['package_vars']['reseller_account']) && $args['package_vars']['reseller_account'] == 1) {
            $server = $this->getServer($args);
            // update reseller account if necessary
            if ($userName != $args['package']['username'] || $password != $args['package']['password']) {
                $tUser = new User($args['customer']['id']);
                $userID = $this->getUserId($args, $server);
                $result = $server->updateAccount($tUser, $userID, $userName, $password);
                if (is_a($result, 'CE_Error')) {
                    return $result;
                }
            }
        } else {
          $server = $this->getServer($args);
        }

        // unset package attributes must be set to 0
        if ($packageVars) {
            $variables = $this->getVariables();
            $variables = array_keys($variables['package_vars_values']['value']);
            $attributes = array();
            foreach ($variables as $variable) {
                $attributes[$variable] = 0;
            }
            $packageVars = array_merge($attributes, $packageVars);
        }
        if($args['package']['name_on_server']!=null && $args['package']['name_on_server']!= ''){
            $packageVars['PackageNameOnServer'] = $args['package']['name_on_server'];
            $variables = $this->getVariables();
            foreach($variables['package_vars_values']['value'] AS $varName=>$attrs){
                if(isset($attrs['template']) && $attrs['template']){
                    $packageVars['TemplateAttr'][] = $varName;
                }
            }
        }
        $domainID = $this->getDomainId($args, $server);
        $result = $server->updateDomain($domainID, $userName, $password, $ip, $packageVars);

        if (is_a($result, 'CE_Error')) {
            CE_Lib::log(4,"Error code = ".$result);
            return $result;
        }
        return true;
    }

    function delete($args, $server = false)
    {
        $server = $this->getServer($args);
        // delete user account
        $userID = $this->getUserId($args, $server);
        $response = $server->deleteUser($userID);
        if (is_a($response, 'CE_Error')) {
            return $response;
        }

       /* $domainID = $this->getDomainId($args, $server);
        $response = $server->deleteDomain($domainID);
        if (is_a($response, 'CE_Error')) {
            return $response;
        }*/
        return true;
    }

    function suspend($args, $server = false)
    {
        $server = $this->getServer($args);
        if (isset($args['package_vars']['reseller_account']) && $args['package_vars']['reseller_account'] == 1) {
            // suspend user account
            // Plesk is not responding well to this command
            $userID = $this->getUserId($args, $server);
            $response = $server->setUserStatus($userID, 16);
            if (is_a($response, 'CE_Error')) {
                return $response;
            }
            $domainID = $this->getDomainId($args, $server);
            $response = $server->setDomainStatus($domainID, 16);
        	if (is_a($response, 'CE_Error')) {
                    return $response;
            }
        }else{
            $domainID = $this->getDomainId($args, $server);
            $response = $server->setDomainStatus($domainID, 32);
        	if (is_a($response, 'CE_Error')) {
                    return $response;
            }
        }
    }

    function unsuspend($args, $server = false)
    {
        $server = $this->getServer($args);
        if (isset($args['package_vars']['reseller_account']) && $args['package_vars']['reseller_account'] == 1) {
            // unsuspend user account
            // Plesk is not responding well to this command
            $userID = $this->getUserId($args, $server);
            $response = $server->setUserStatus($userID, 0);
            if (is_a($response, 'CE_Error')) {
                return $response;
            }
        }
        $domainID = $this->getDomainId($args, $server);
        $response = $server->setDomainStatus($domainID, 0);
        if (is_a($response, 'CE_Error')) {
                return $response;
        }
    }

    function doCreate($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->create($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") . ' has been created.';
    }

    function doSuspend($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->suspend($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") . ' has been suspended.';
    }

    function doUnSuspend($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->unsuspend($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") . ' has been unsuspended.';
    }

    function doDelete($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->delete($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") . ' has been deleted.';
    }


    function doUpdate($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->update($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") . ' has been updated.';
    }

    function getAvailableActions($userPackage)
    {
        $args = $this->buildParams($userPackage);
        $actions = array();
        try {
            $server = $this->getServer($args);
            $response = $server->getDomainInfo($args['package']['domain_name']);
            $status = $response['packet']['#']['domain'][0]['#']['get'][0]['#']['result'][0]['#']['data'][0]['#']['gen_info'][0]['#']['status'][0]['#'];
            $actions[] = 'Delete';
            if ( $status == '0' ) {
                $actions[] = 'Suspend';
            } else {
                $actions[] = 'UnSuspend';
            }
        } catch (Exception $e) {
            $actions[] = 'Create';
        }
        return $actions;
    }

    function getServer($args)
    {
        if ( isset($args['package']['variables']['reseller_account']) && $args['package']['variables']['reseller_account'] == 1 )
        {
          $server = new PleskServer($this->settings, $args['server']['variables']['ServerHostName'], $args['server']['variables']['plugin_plesk_Username'], $args['server']['variables']['plugin_plesk_Password']);
        }
        else
        {
            if ($args['server']['variables']['plugin_plesk_Non-Admin_Username'] != '' && $args['server']['variables']['plugin_plesk_Non-Admin_Password'] != '') {
                $server = new PleskServer($this->settings, $args['server']['variables']['ServerHostName'], $args['server']['variables']['plugin_plesk_Non-Admin_Username'], $args['server']['variables']['plugin_plesk_Non-Admin_Password']);
            } else {
                $server = new PleskServer($this->settings, $args['server']['variables']['ServerHostName'], $args['server']['variables']['plugin_plesk_Username'], $args['server']['variables']['plugin_plesk_Password']);
            }
        }
        return $server;
    }

    function getDomainId($args, $server)
    {
        return $server->getDomainId($args['package']["domain_name"]);
    }

    function getUserId($args, $server)
    {
        return $server->getUserId($args['package']["username"]);
    }

    function getResellerId($args, $server)
    {
        return $server->getResellerId($args['package']["username"]);
    }
}
?>