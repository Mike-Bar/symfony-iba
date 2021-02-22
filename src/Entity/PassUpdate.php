<?php

namespace App\Entity;

use App\Repository\PassUpdateRepository;
use Symfony\Component\Validator\Constraints as Assert;

class PassUpdate
{  
    private $oldPass;

    
    /**
     *@Assert\Length(min=8, minMessage="Le mot de passe doit faire au moins 8 caractères !")
     */
    private $newPass;

    /**
     *@Assert\EqualTo(propertyPath="newPass", message="Confirmez votre mot de passe !")
     */
    private $confirmPass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldPass(): ?string
    {
        return $this->oldPass;
    }

    public function setOldPass(string $oldPass): self
    {
        $this->oldPass = $oldPass;

        return $this;
    }

    public function getNewPass(): ?string
    {
        return $this->newPass;
    }

    public function setNewPass(string $newPass): self
    {
        $this->newPass = $newPass;

        return $this;
    }

    public function getConfirmPass(): ?string
    {
        return $this->confirmPass;
    }

    public function setConfirmPass(string $confirmPass): self
    {
        $this->confirmPass = $confirmPass;

        return $this;
    }
}
