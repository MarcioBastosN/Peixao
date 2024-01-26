<?php

date_default_timezone_set('America/Belem');

@$Data = date("d-m-Y");
@$vetor = array('Data' => $Data);

echo "[", json_encode($vetor), "]";