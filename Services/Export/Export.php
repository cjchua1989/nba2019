<?php
namespace Services\Export;

interface Export {
    public function render($data): string;
}