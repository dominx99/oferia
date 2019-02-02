<?php

function dd()
{
    echo "<pre>";
    die(
        var_dump(
            func_get_args()
        )
    );
    echo "</pre>";
}
