<?php

namespace App\Services\GameData;

use App\Exceptions\CompanionMarketServerException;
use Delight\Cookie\Cookie;

class GameServers
{
    /**
     * It is important new servers are added to the end of this list.
     */
    const LIST = [
        'Adamantoise',
        'Aegis',
        'Alexander',
        'Anima',
        'Asura',
        'Atomos',
        'Bahamut',
        'Balmung',
        'Behemoth',
        'Belias',
        'Brynhildr',
        'Cactuar',
        'Carbuncle',
        'Cerberus',
        'Chocobo',
        'Coeurl',
        'Diabolos',
        'Durandal',
        'Excalibur',
        'Exodus',
        'Faerie',
        'Famfrit',
        'Fenrir',
        'Garuda',
        'Gilgamesh',
        'Goblin',
        'Gungnir',
        'Hades',
        'Hyperion',
        'Ifrit',
        'Ixion',
        'Jenova',
        'Kujata',
        'Lamia',
        'Leviathan',
        'Lich',
        'Louisoix',
        'Malboro',
        'Mandragora',
        'Masamune',
        'Mateus',
        'Midgardsormr',
        'Moogle',
        'Odin',
        'Omega',
        'Pandaemonium',
        'Phoenix',
        'Ragnarok',
        'Ramuh',
        'Ridill',
        'Sargatanas',
        'Shinryu',
        'Shiva',
        'Siren',
        'Tiamat',
        'Titan',
        'Tonberry',
        'Typhon',
        'Ultima',
        'Ultros',
        'Unicorn',
        'Valefor',
        'Yojimbo',
        'Zalera',
        'Zeromus',
        'Zodiark',
    ];
    
    const LIST_DC = [
        'Elemental' => [
            'Aegis',
            'Atomos',
            'Carbuncle',
            'Garuda',
            'Gungnir',
            'Kujata',
            'Ramuh',
            'Tonberry',
            'Typhon',
            'Unicorn'
        ],
        'Gaia' => [
            'Alexander',
            'Bahamut',
            'Durandal',
            'Fenrir',
            'Ifrit',
            'Ridill',
            'Tiamat',
            'Ultima',
            'Valefor',
            'Yojimbo',
            'Zeromus',
        ],
        'Mana' => [
            'Anima',
            'Asura',
            'Belias',
            'Chocobo',
            'Hades',
            'Ixion',
            'Mandragora',
            'Masamune',
            'Pandaemonium',
            'Shinryu',
            'Titan',
        ],
        'Aether' => [
            'Adamantoise',
            'Balmung',
            'Cactuar',
            'Coeurl',
            'Faerie',
            'Gilgamesh',
            'Goblin',
            'Jenova',
            'Mateus',
            'Midgardsormr',
            'Sargatanas',
            'Siren',
            'Zalera',
        ],
        'Primal' => [
            'Behemoth',
            'Brynhildr',
            'Diabolos',
            'Excalibur',
            'Exodus',
            'Famfrit',
            'Hyperion',
            'Lamia',
            'Leviathan',
            'Malboro',
            'Ultros',
        ],
        'Chaos' => [
            'Cerberus',
            'Lich',
            'Louisoix',
            'Moogle',
            'Odin',
            'Omega',
            'Phoenix',
            'Ragnarok',
            'Shiva',
            'Zodiark',
        ],
    ];
    
    /**
     * Get the users current server
     */
    public static function getServer(): string
    {
        return Cookie::get('server') ?: 'Phoenix';
    }
    
    /**
     * Get a server id from a server string
     */
    public static function getServerId(string $server): int
    {
        $index = array_search(ucwords($server), GameServers::LIST);
        
        if ($index === false) {
            throw new CompanionMarketServerException();
        }
        
        return $index;
    }
    
    /**
     * Get the Data Center for
     */
    public static function getDataCenter(string $server): ?string
    {
        foreach (GameServers::LIST_DC as $dc => $servers) {
            if (in_array($server, $servers)) {
                return $dc;
            }
        }
        
        return 'Chaos';
    }
    
    /**
     * Get the data center servers for a specific server
     */
    public static function getDataCenterServers(string $server): ?array
    {
        $dc = self::getDataCenter($server);
        return $dc ? GameServers::LIST_DC[$dc] : null;
    }
}