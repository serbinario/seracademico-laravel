<?php
namespace Seracademico\Contracts;

interface GnetBoleto
{
    public function getName();
    public function getQtd();
    public function getValue();
    public function getDueDate();
}