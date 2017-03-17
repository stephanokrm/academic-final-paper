<?php

namespace Academic\Transformers;

class EventTransformer {

    public static function fromGoogleEventsToArray($googleEvents, $idCalendar) {
        return array_map(function($googleEvent) use ($idCalendar) {
            $event['id'] = $googleEvent->getId();
            $event['title'] = $googleEvent->getSummary();
            $event['start'] = $googleEvent->getStart()->getDate() ? $googleEvent->getStart()->getDate() : $googleEvent->getStart()->getDateTime();
            $event['end'] = $googleEvent->getEnd()->getDate() ? $googleEvent->getEnd()->getDate() : $googleEvent->getEnd()->getDateTime();
            $event['description'] = $googleEvent->getDescription();
            $event['color'] = $googleEvent->getColorId();
            $event['calendar'] = $idCalendar;
            switch ($event['color']) {
                case 11:
                    $event['backgroundColor'] = '#dc2127';
                    $event['borderColor'] = '#dc2127';
                    $event['textColor'] = '#FFF';
                    break;
                case 10:
                    $event['backgroundColor'] = '#51b749';
                    $event['borderColor'] = '#51b749';
                    $event['textColor'] = '#FFF';
                    break;
                case 9:
                    $event['backgroundColor'] = '#5484ed';
                    $event['borderColor'] = '#5484ed';
                    $event['textColor'] = '#FFF';
                    break;
                case 8:
                    $event['backgroundColor'] = '#e1e1e1';
                    $event['borderColor'] = '#e1e1e1';
                    $event['textColor'] = '#FFF';
                    break;
                case 7:
                    $event['backgroundColor'] = '#46d6db';
                    $event['borderColor'] = '#46d6db';
                    $event['textColor'] = '#FFF';
                    break;
                case 6:
                    $event['backgroundColor'] = '#ffb878';
                    $event['borderColor'] = '#ffb878';
                    $event['textColor'] = '#FFF';
                    break;
                case 5:
                    $event['backgroundColor'] = '#fbd75b';
                    $event['borderColor'] = '#fbd75b';
                    $event['textColor'] = '#FFF';
                    break;
                case 4:
                    $event['backgroundColor'] = '#ff887c';
                    $event['borderColor'] = '#ff887c';
                    $event['textColor'] = '#FFF';
                    break;
                case 3:
                    $event['backgroundColor'] = '#dbadff';
                    $event['borderColor'] = '#dbadff';
                    $event['textColor'] = '#FFF';
                    break;
                case 2:
                    $event['backgroundColor'] = '#7ae7bf';
                    $event['borderColor'] = '#7ae7bf';
                    $event['textColor'] = '#FFF';
                    break;
                case 1:
                    $event['backgroundColor'] = '#a4bdfc';
                    $event['borderColor'] = '#a4bdfc';
                    $event['textColor'] = '#FFF';
                    break;
                default:
                    $event['backgroundColor'] = '#9fe1e7';
                    $event['borderColor'] = '#9fe1e7';
                    $event['textColor'] = '#FFF';
                    break;
            }
            return $event;
        }, $googleEvents);
    }

}
