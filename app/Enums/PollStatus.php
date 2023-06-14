<?php

namespace App\Enums;

enum PollStatus : string {
    case CLOSED = 'CLOSED';
    case OPENED = 'OPENED';
}