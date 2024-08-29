<?php

namespace services;

use Exception;
use entities\Compte;

class HabMailerException extends Exception
{
}

class HabMailer
{
    const COMPTE_CREATION = 'compte_creation';
    const COMPTE_VALIDATION = 'compte_validation';

    public static function getFrom($type)
    {
        self::validateMailType($type);

        if ($type === self::COMPTE_CREATION) {
            $email = $_ENV['MAILER_COMPTE_CREATION_BY_RH_FROM'];
            $firstname = $_SESSION['user']['firstname'] ?? "RH";
            $lastname = $_SESSION['user']['lastname'] ?? "Manager";
            $name = $firstname . " " . $lastname;
            return [
                'email' => $email,
                'name' => $name
            ];
        } elseif ($type === self::COMPTE_VALIDATION) {
            return $_ENV['MAILER_COMPTE_CREATION_OR_CREATION_BY_ADMIN_FROM'];
        }
    }

    public static function getMainRecipients($type)
    {
        self::validateMailType($type);

        if ($type === self::COMPTE_CREATION) {
            $recipients = $_ENV['MAILER_COMPTE_CREATION_RECIPIENTS_MAIN'] ?? '';
            $recipients = explode(',', $recipients);
            return $recipients;
        } elseif ($type === self::COMPTE_VALIDATION) {
            $recipients = $_ENV['MAILER_COMPTE_VALIDATION_RECIPIENTS_MAIN'] ?? '';
            $recipients = explode(',', $recipients);
            return $recipients;
        }
    }

    public static function getCCRecipients($type)
    {
        if ($type === self::COMPTE_CREATION) {
            $recipients = $_ENV['MAILER_COMPTE_CREATION_RECIPIENTS_CC'] ?? '';
            $recipients = explode(',', $recipients);
            return $recipients;
        } elseif ($type === self::COMPTE_VALIDATION) {
            $recipients = $_ENV['MAILER_COMPTE_VALIDATION_RECIPIENTS_CC'] ?? '';
            $recipients = explode(',', $recipients);
            return $recipients;
        }
    }

    public static function getSubject($type, Compte $compte, $action = null, $date = null)
    {
        self::validateMailType($type);

        if ($type === self::COMPTE_CREATION) {
            if ($action === "modifier") {
                return "Demande de modification du compte de " . self::getName($compte);
            } elseif ($action === "desactiver") {
                return "Demande de désactivation du compte de " . self::getName($compte);
            }
            return "Demande d'habilitation - " . self::getName($compte);
        } elseif ($type === self::COMPTE_VALIDATION) {
            return "Validation de compte - " . self::getName($compte);
        }
    }

    public static function getBody($type, $compte, $serviceName, $action = null, $date = null)
    {
        self::validateMailType($type);
        $data = [];
        $data["compteName"] = $compte->getTitre() . " " . $compte->getPrenom() . " " . $compte->getNom();
        $data["dateEmbauche"] = date("d.m.Y", strtotime($compte->getDateEmbauche()));
        $data["entiteeFonctionnelle"] = $compte->getEntiteeFonctionnelle();
        $data["email"] = $compte->getEmail();
        $data["codeRacf"] = $compte->getIdNeptune();
        $data["sitePhysique"] = $compte->getSitePhysique();
        $data["service"] = $serviceName;
        $data["dateNaissance"] = date("d/m/Y", strtotime($compte->getDateNaissance()));
        $data["CodeProtea"] = $compte->getUserProtea();
        $data["telInterne"] = $compte->getTelInterne();
        $data["telExterne"] = $compte->getTelExterne();
        $data["motDePasse"] = $compte->getMotDePasse();
        $data["motDePassePortea"] = $compte->getMotDePassePortea();
        $data["natureDemande"] = $compte->getNatureContrat();
        $data["date_fin"] = $date ? date("d.m.Y", strtotime($date)) : "";
        $data["fonction"] = $compte->getFonction();
        if ($type === self::COMPTE_CREATION) {
            ob_start();
            extract($data);
            if ($action === "modifier") {
                require_once APP_ROOT . '/views/mails/compte_modification.php';
            } elseif ($action === "desactiver") {
                require_once APP_ROOT . '/views/mails/compte_desactivation.php';
            } else {
                require_once APP_ROOT . '/views/mails/compte_creation.php';
            }
            return ob_get_clean();
        } elseif ($type === self::COMPTE_VALIDATION) {
            ob_start();
            extract($data);
            require_once APP_ROOT . '/views/mails/compte_validation.php';
            return ob_get_clean();
        }
    }

    private static function getName(Compte $compte)
    {
        $firstLetter = substr($compte->getPrenom(), 0, 1);
        return $firstLetter . ". " . $compte->getNom();
    }

    private static function validateMailType($type)
    {
        if (!in_array($type, [self::COMPTE_CREATION, self::COMPTE_VALIDATION])) {
            throw new HabMailerException("Invalid mail type");
        }
    }
}
