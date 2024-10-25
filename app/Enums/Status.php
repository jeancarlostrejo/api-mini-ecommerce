<?php 

namespace App\Enums;

enum Status: string {
    case Pending = 'pending';
    case Delivered = 'delivered';
    case OutOfDelivery = 'out_of_delivery';
    case Canceled = 'canceled';
    case Accepted = 'accepted';
}