<?php

function getStatus($status)
{

    switch ($status) {
        case '1':
            $label = '<div class="badge text-bg-primary">Sedang dipinjam</div>';
            break;
        case '2':
            $label = '<span class="badge  text-bg-success">Sudah dikembalikan</span>';
            break;
        default:
            $label = "duarr";
            break;
    }
    return $label;
}
