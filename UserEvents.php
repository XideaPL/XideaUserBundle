<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
final class UserEvents
{
    /**
     * The PRE_SAVE event occurs when the user is saved.
     */
    const PRE_SAVE = 'xidea_user.user.pre_save';
    
    /**
     * The POST_SAVE event occurs when the user is saved.
     */
    const POST_SAVE = 'xidea_user.user.post_save';
    
    /**
     * The REGISTRATION_INITIALIZE event occurs when the registration process is initialized.
     */
    const REGISTRATION_INITIALIZE = 'xidea_user.user.registration_initialize';
    
    /**
     * The PRE_REGISTRATION event occurs when the registration process is initialized.
     */
    const PRE_REGISTRATION = 'xidea_user.user.pre_registration';
    
    /**
     * The REGISTRATION_SUCCESS event occurs when the registration process is initialized.
     */
    const REGISTRATION_SUCCESS = 'xidea_user.user.registration_success';
    
    /**
     * The REGISTRATION_FORM_VALID event occurs when the registration process is initialized.
     */
    const REGISTRATION_FORM_VALID = 'xidea_user.user.registration_form_valid';
    
    /**
     * The REGISTRATION_COMPLETED event occurs when the registration process is initialized.
     */
    const REGISTRATION_COMPLETED = 'xidea_user.user.registration_completed';
    
    /**
     * The CHANGE_PASSWORD_INITIALIZE event occurs when the registration process is initialized.
     */
    const CHANGE_PASSWORD_INITIALIZE = 'xidea_user.user.change_password_initialize';
    
    /**
     * The CHANGE_PASSWORD_SUCCESS event occurs when the registration process is initialized.
     */
    const CHANGE_PASSWORD_SUCCESS = 'xidea_user.user.change_password_success';
    
    /**
     * The CHANGE_PASSWORD_FORM_VALID event occurs when the registration process is initialized.
     */
    const CHANGE_PASSWORD_FORM_VALID = 'xidea_user.user.change_password_form_valid';
    
    /**
     * The CHANGE_PASSWORD_COMPLETED event occurs when the registration process is initialized.
     */
    const CHANGE_PASSWORD_COMPLETED = 'xidea_user.user.change_password_completed';
}
