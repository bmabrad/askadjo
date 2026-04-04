<?php

namespace App\Enums;

enum Platform: string
{
    case Tinder = 'tinder';
    case Bumble = 'bumble';
    case Hinge = 'hinge';
    case Instagram = 'instagram';
    case IMessage = 'imessage';
    case WhatsApp = 'whatsapp';
    case Other = 'other';
}
