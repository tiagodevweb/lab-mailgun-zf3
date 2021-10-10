<?php

namespace CodeEmailMKT\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enderecos")
 */
class Endereco
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cep;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $logradouro;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cidade;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $estado;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }
}
