<?php

namespace App\googleAPI;
use App\Core\Model;


class calendar extends Model
{


    public function add_turno_calendar($user,$date,$hour,$artist,$link)
    {
        $m["error"] = ''; //for error messages
        $m["ok"] = ''; //for link event
        $id_event = ''; //id event created
        $link_event = '';

    $fulldate = $date." ".$hour;

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $filename = 'inkmaster-5c705d4e9dd8.json';
    $pathname = realpath(join('/', [__DIR__, $filename]));
    //configurar variable de entorno / set enviroment variable
    putenv("GOOGLE_APPLICATION_CREDENTIALS=$pathname");

    $client = new \Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->setScopes(['https://www.googleapis.com/auth/calendar']);

    //define id calendario
    //$id_calendar = '2kh2fa1hufh640kggiaja7at10@group.calendar.google.com';//
    $id_calendar = $link;

    //$datetime_start = new \DateTime('2020-07-11 18:50');
    //$datetime_end = new \DateTime('2020-07-11 18:50');
            $datetime_start = new \DateTime($fulldate);
            $datetime_end = new \DateTime($fulldate);


        //aumentamos una hora a la hora inicial/ add 1 hour to start date
    $time_end = $datetime_end->add(new \DateInterval('PT1H'));

    //datetime must be format RFC3339
    $time_start = $datetime_start->format(\DateTime::RFC3339);
    $time_end = $time_end->format(\DateTime::RFC3339);


    $nombre = $user;
    try {

        //instanciamos el servicio
        $calendarService = new \Google_Service_Calendar($client);


        //parámetros para buscar eventos en el rango de las fechas del nuevo evento
        //params to search events in the given dates
        $optParams = array(
            'orderBy' => 'startTime',
            'maxResults' => 20,
            'singleEvents' => TRUE,
            'timeMin' => $time_start,
            'timeMax' => $time_end,
        );

        //obtener eventos
        $events = $calendarService->events->listEvents($id_calendar, $optParams);

        //obtener número de eventos / get how many events exists in the given dates
        $cont_events = count($events->getItems());

        //crear evento si no hay eventos / create event only if there is no event in the given dates
        if ($cont_events == 0) {

            $event = new \Google_Service_Calendar_Event();
            $event->setSummary('Turno con el paciente ' . $nombre);
            $event->setDescription('Tatuaje');

            //fecha inicio
            $start = new \Google_Service_Calendar_EventDateTime();
            $start->setDateTime($time_start);
            $event->setStart($start);

            //fecha fin
            $end = new \Google_Service_Calendar_EventDateTime();
            $end->setDateTime($time_end);
            $event->setEnd($end);


            $createdEvent = $calendarService->events->insert($id_calendar, $event);
            $id_event = $createdEvent->getId();
            $link_event = $createdEvent->gethtmlLink();
            $m["ok"] = $link_event;
            return $m;

        } else {
            $m["error"] = "Hay " . $cont_events . " eventos en ese rango de fechas";
            return $m;
        }


    } catch (Google_Service_Exception $gs) {

        $m["error"] = json_decode($gs->getMessage());
        $m["error"] = $m->error->message;
        return $m;

    } catch (Exception $e) {
        $m["error"] = $e->getMessage();
        return $m;
    }
    }
}

