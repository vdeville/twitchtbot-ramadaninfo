<?php


/**
 * Class Ramadaninfo
 */
class Ramadaninfo
{
    use \TwitchBot\Module;

    /**
     * Ramadaninfo constructor.
     * @param array $infos
     * @param \TwitchBot\IrcConnect $client
     */
    public function __construct(array $infos, $client)
    {
        $this->client = $client;
        $this->infos = $infos;
    }

    public function onConnect()
    {
        $this->getClient()->sendMessage('Plugin Ramadan activate !');
    }

    /**
     * @param \TwitchBot\Message $data
     */
    public function onMessage($data)
    {
        if($data->getMessage()[0] == '!'){

            $command = trim($data->getMessage());
            $command = substr($command, 1);
            $command = explode(' ',$command)[0];

            $command = strtolower($command);

            if($command == 'ramadan'){
                if($this->checkRamadan()){
                    $this->getClient()->sendMessage($data->getUsername() . ', tu peux manger ! Keepo Keepo');
                } else {
                    $this->getClient()->sendMessage($data->getUsername() . ', tu ne peux pas encore manger, un peu de patience !');
                }
            }

        }
    }

    /**
     * @return bool
     */
    public function checkRamadan(){
        $tomorow = new \DateTime();
        $tomorow->add((new DateInterval('P1D')));

        $sunset = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, 48.8564519, 2.3446371, 90, 1);
        $sunrise = date_sunrise($tomorow->getTimestamp(), SUNFUNCS_RET_TIMESTAMP, 48.8564519, 2.3446371, 90, 1);

        $now = new \DateTime();

        if( ($now->getTimestamp() > $sunset) AND ($now->getTimestamp() < $sunrise) ){
            return true;
        } else {
            return false;
        }
    }
}