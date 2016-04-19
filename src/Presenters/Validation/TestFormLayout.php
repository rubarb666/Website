<?php

namespace Rhubarb\Website\Presenters\Validation;

trait TestFormLayout
{
    protected $includeInputMessageTargets = true;

    protected function printForm()
    {
        $messageTarget = ($this->includeInputMessageTargets) ? '<span class="js-validation-message"></span>' : ''
        ?>
        <h2>Create your Account</h2>

        <div class="c-form c-form--constrained-width">
			<div id="overall-form">
                <span class="js-validation-message"></span>
            </div>
            <h3>Personal Details</h3>
            <div class="c-form__group c-form__group--inline">
                <div id="title-validation" class="is-required">
                    <label class="c-form__label">Title</label>
                    <div class="c-form__input-group">
                        <select name="Title" id="Title" presenter-name="Title">
                            <option value="" selected="selected" data-item="{&quot;value&quot;:&quot;&quot;,&quot;label&quot;:&quot;&quot;,&quot;data&quot;:[]}"></option>
                            <option value="Mr" data-item="{&quot;value&quot;:&quot;Mr&quot;,&quot;label&quot;:&quot;Mr&quot;,&quot;data&quot;:[]}">Mr</option>
                            <option value="Mrs" data-item="{&quot;value&quot;:&quot;Mrs&quot;,&quot;label&quot;:&quot;Mrs&quot;,&quot;data&quot;:[]}">Mrs</option>
                            <option value="Miss" data-item="{&quot;value&quot;:&quot;Miss&quot;,&quot;label&quot;:&quot;Miss&quot;,&quot;data&quot;:[]}">Miss</option>
                            <option value="Ms" data-item="{&quot;value&quot;:&quot;Ms&quot;,&quot;label&quot;:&quot;Ms&quot;,&quot;data&quot;:[]}">Ms</option>
                            <option value="Dr" data-item="{&quot;value&quot;:&quot;Dr&quot;,&quot;label&quot;:&quot;Dr&quot;,&quot;data&quot;:[]}">Dr</option>
                        </select>                </div>
                    <?=$messageTarget;?>
                </div>
                <div id="forename-validation" class="is-required">
                    <label class="c-form__label">First Name</label>
                    <input size="15" name="Forename" value="" id="Forename" presenter-name="Forename" placeholder="First Name" type="text">
                    <?=$messageTarget;?>
                </div>
                <div id="surname-validation" class="is-required">
                    <label class="c-form__label">Last Name</label>
                    <input size="15" name="Surname" value="" id="Surname" presenter-name="Surname" placeholder="Last Name" type="text">
                    <?=$messageTarget;?>
                </div>
            </div>

            <div class="c-form__group">
                <div id="phonenumber-validation">
                    <label class="c-form__label">Phone Number</label>
                    <input size="40" name="PhoneNumber" value="" id="PhoneNumber" presenter-name="PhoneNumber" placeholder="Phone" type="tel">
                    <?=$messageTarget;?>
                </div>
            </div>

            <div class="c-form__group" id="address-validation">

                <div class="c-form__group">
                    <label class="c-form__label" for="Organisation">Organisation</label>

                    <div class="c-form__inputs">
                        <input size="50" name="Organisation" value="" id="Organisation" presenter-name="Organisation" class="paf-address-field" type="text">
                        <em class="validation-placeholder" name="ValidationPlaceHolder-Organisation"></em>            </div>
                </div>
                <div class="c-form__group">
                    <label class="c-form__label" for="AddressLine1">Address Line 1</label>

                    <div class="c-form__inputs">
                        <input size="50" name="AddressLine1" value="" id="AddressLine1" presenter-name="AddressLine1" class="paf-address-field" type="text">
                        <em class="validation-placeholder" name="ValidationPlaceHolder-AddressLine1"></em>            </div>
                </div>
                <div class="c-form__group">
                    <label class="c-form__label" for="AddressLine2">Address Line 2</label>

                    <div class="c-form__inputs">
                        <input size="30" name="AddressLine2" value="" id="AddressLine2" presenter-name="AddressLine2" class="paf-address-field" type="text">
                        <em class="validation-placeholder" name="ValidationPlaceHolder-AddressLine2"></em>            </div>
                </div>
                <div class="c-form__group">
                    <label class="c-form__label" for="AddressLine3">Address Line 3</label>

                    <div class="c-form__inputs">
                        <input size="30" name="AddressLine3" value="" id="AddressLine3" presenter-name="AddressLine3" class="paf-address-field" type="text">
                        <em class="validation-placeholder" name="ValidationPlaceHolder-AddressLine3"></em>            </div>
                </div>
                <div class="c-form__group">
                    <label class="c-form__label" for="Town">Town</label>

                    <div class="c-form__inputs">
                        <input size="30" name="Town" value="" id="Town" presenter-name="Town" class="paf-address-field" type="text">
                        <em class="validation-placeholder" name="ValidationPlaceHolder-Town"></em>            </div>
                </div>
                <div class="c-form__group">
                    <label class="c-form__label" for="County">County</label>

                    <div class="c-form__inputs">
                        <input size="20" name="County" value="" id="County" presenter-name="County" class="paf-address-field" type="text">
                        <em class="validation-placeholder" name="ValidationPlaceHolder-County"></em>            </div>
                </div>
                <div class="c-form__group">
                    <label class="c-form__label" for="Postcode">Postcode</label>

                    <div class="c-form__inputs">
                        <input size="10" name="Postcode" value="" id="Postcode" presenter-name="Postcode" class="paf-address-field" type="text">
                        <em class="validation-placeholder" name="ValidationPlaceHolder-Postcode"></em>            </div>
                </div>
            </div>

            <div class="new-account-group">
                <h3 class="u-mob-down">Account Details</h3>
                <div class="c-form__group" id="email-validation">
                    <label class="c-form__label">Email Address</label>
                    <input size="40" name="Email" value="" id="Email" presenter-name="Email" placeholder="Email" type="email">
                    <?=$messageTarget;?>
                </div>
                <div class="c-form__group" id="password-validation">
                    <div class="c-form__group--inline">
                        <div>
                            <label class="c-form__label">Password</label>
                            <input size="40" name="Password" value="" id="Password" presenter-name="Password" placeholder="Password" type="password">
                        </div>

                        <div>
                            <label class="c-form__label">Confirm Password</label>
                            <input size="40" name="ConfirmPassword" value="" id="ConfirmPassword" presenter-name="ConfirmPassword" placeholder="Confirm Password" type="password">
                        </div>
                    </div>
                    <?=$messageTarget;?>
                </div>
                <div class="c-form__group sign-up">
                    <label>
                        <input value="1" name="MailingList" id="MailingList" presenter-name="MailingList" type="checkbox">
                        <span>I'd like to receive offers from WeAreVertigo</span>
                    </label>
                </div>
            </div>

            <div class="c-form__actions">
                <a id="create-button" class="c-button c-button--continue c-button-large create-button with-spinner">Create Account</a>
            </div>

        </div> <!-- end of c-form -->
    <?php
    }
}