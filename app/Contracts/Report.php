<?php
namespace Seracademico\Contracts;


interface Report
{
    public function generate($id);

    public function getReports();
}