<?php
namespace Seracademico\Contracts;


interface Report
{
    public function generate($id, $filters);

    public function getReports();
}