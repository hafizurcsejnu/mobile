<?php


->where('client_id', session('client_id'))

(session('bt') == 'f')

if (session('bt') == 'f') {
    
}


distinct


$data = DB::table('payments')
        ->where('created_at', 'like', '%' .$start_date. '%')
        ->where('client_id', session('client_id'))
        ->where('active', 'on')
        ->orderBy('id', 'asc')
        ->distinct()
        ->get('order_id');


sql:
=====

UPDATE `products` SET `active`='on'
UPDATE `products` SET `client_id`='3'




        // UPDATE `products` SET `model`='10x16' WHERE `client_id`='4' and `model`='10X16';
        // UPDATE `products` SET `model`='16x16' WHERE `client_id`='4' and `model`='16X16';
        // UPDATE `products` SET `model`='24x24' WHERE `client_id`='4' and `model`='24X24';

        // UPDATE `products` SET `model`='32x32' WHERE `client_id`='4' and `model`='32X32';
        // UPDATE `products` SET `model`='24x48' WHERE `client_id`='4' and `model`='24X48';



