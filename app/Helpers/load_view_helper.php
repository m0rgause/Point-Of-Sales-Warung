<?php

function load_view(string $body_view, array $data, string $type='public'): string
{
    $folder_template = 'templates/';
    if($type === 'admin') $folder_template = 'template_admins/';
    $view = view($folder_template.'header', $data);
    $view .= view($body_view);
    $view .= view($folder_template.'footer');
    
    return $view;
}