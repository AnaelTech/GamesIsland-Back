<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Game;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('LuniiiKzz');
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER']);

        // Hasher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'test123' // Mot de passe en clair (à hasher)
        );
        $user->setPassword($hashedPassword);

        $user->setDateJoined(new \DateTime('now'));
        $user->setAvatar(null); // Optionnel, tu peux mettre une valeur si nécessaire
        $user->setActive(true);

        // Persist et flush
        $manager->persist($user);


        $developers = [
            [
                'username' => 'StudioPapangue',
                'email' => 'studiopapangue@email.com',
                'studioName' => 'Studio Papangue',
                'website' => 'https://www.papangue.com',
                'password' => 'test123',
                'dateJoined' => new \DateTime('now'),
                'active' => true,
            ],
            [
                'username' => 'PixelForge',
                'email' => 'contact@pixelforge.com',
                'studioName' => 'Pixel Forge',
                'website' => 'https://www.pixelforge.com',
                'password' => 'securepassword',
                'dateJoined' => new \DateTime('2022-03-15'),
                'active' => true,
            ],
            [
                'username' => 'GameMastersInc',
                'email' => 'info@gamemasters.com',
                'studioName' => 'Game Masters Inc.',
                'website' => 'https://www.gamemasters.com',
                'password' => 'gamepass',
                'dateJoined' => new \DateTime('2021-07-22'),
                'active' => true,
            ],
            [
                'username' => 'EpicGamesStudio',
                'email' => 'hello@epicgames.com',
                'studioName' => 'Epic Games Studio',
                'website' => 'https://www.epicgames.com',
                'password' => 'epicpassword',
                'dateJoined' => new \DateTime('2020-11-05'),
                'active' => true,
            ],
            [
                'username' => 'RetroGaming',
                'email' => 'support@retrogaming.com',
                'studioName' => 'Retro Gaming',
                'website' => 'https://www.retrogaming.com',
                'password' => 'retro123',
                'dateJoined' => new \DateTime('2019-08-30'),
                'active' => true,
            ],
        ];
        $developerEntities = [];
        foreach ($developers as $devData) {
            $developer = new Developer();
            $developer->setUsername($devData['username'])
                ->setEmail($devData['email'])
                ->setRoles(['ROLE_DEVELOPER'])
                ->setStudioName($devData['studioName'])
                ->setWebsite($devData['website'])
                ->setDateJoined($devData['dateJoined'])
                ->setActive($devData['active']);

            // Hasher le mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword(
                $developer,
                $devData['password']
            );
            $developer->setPassword($hashedPassword);

            $manager->persist($developer);
            $developerEntities[] = $developer;
        }

        $games = [
            [
                'title' => 'Super Mario 64',
                'description' => 'Super Mario 64 est un jeu vidéo de plateforme Nintendo 64 publié par Nintendo en 1996.',
                'price' => '19.99',
                'releaseDate' => new \DateTime('2001-01-01'),
                'genre' => 'Action',
                'platform' => 'Nintendo 64',
                'coverImage' => '/images/CoverGame/cover-supermario64.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'createdAt' => new \DateTime('2001-01-01'),
                'updateAt' => new \DateTime('2001-01-01'),
            ],
            [
                'title' => 'The Legend of Zelda: Ocarina of Time',
                'description' => 'Jeu d\'action-aventure de Nintendo 64 publié en 1998, considéré comme l\'un des meilleurs jeux de tous les temps.',
                'price' => '29.99',
                'releaseDate' => new \DateTime('1998-11-21'),
                'genre' => 'Aventure',
                'platform' => 'Nintendo 64',
                'coverImage' => '/images/CoverGame/cover-legend-of-zelda-ocarina-of-time.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=2rP_4I64zZs',
                'createdAt' => new \DateTime('1998-11-21'),
                'updateAt' => new \DateTime('1998-11-21'),
            ],
            [
                'title' => 'The Witcher 3: Wild Hunt',
                'description' => 'Jeu de rôle action-aventure développé par CD Projekt Red, sorti en 2015. Réputé pour son monde ouvert riche et immersif.',
                'price' => '39.99',
                'releaseDate' => new \DateTime('2015-05-19'),
                'genre' => 'RPG',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-the-witcher-3.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=c0iZyOm9dI4',
                'createdAt' => new \DateTime('2015-05-19'),
                'updateAt' => new \DateTime('2015-05-19'),
            ],
            [
                'title' => 'Minecraft',
                'description' => 'Un jeu de construction en monde ouvert où les joueurs peuvent explorer, créer et survivre dans un environnement cubique.',
                'price' => '24.99',
                'releaseDate' => new \DateTime('2011-11-18'),
                'genre' => 'Sandbox',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-minecraft.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=MmB9b5njVbA',
                'createdAt' => new \DateTime('2011-11-18'),
                'updateAt' => new \DateTime('2011-11-18'),
            ],
            [
                'title' => 'Red Dead Redemption 2',
                'description' => 'Jeu d\'action-aventure de Rockstar Games, sorti en 2018, se déroulant dans un vaste monde ouvert inspiré de l\'Amérique du 19ème siècle.',
                'price' => '59.99',
                'releaseDate' => new \DateTime('2018-10-26'),
                'genre' => 'Action',
                'platform' => 'PlayStation 4',
                'coverImage' => '/images/CoverGame/cover-red-dead-redemption-2.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=gmA6Bq5z4GQ',
                'createdAt' => new \DateTime('2018-10-26'),
                'updateAt' => new \DateTime('2018-10-26'),
            ],
            [
                'title' => 'Overwatch',
                'description' => 'Jeu de tir en équipe développé par Blizzard Entertainment, lancé en 2016, connu pour ses personnages variés et ses modes de jeu compétitifs.',
                'price' => '39.99',
                'releaseDate' => new \DateTime('2016-05-24'),
                'genre' => 'Shooter',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-overwatch.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=FvnzA2G8ZTA',
                'createdAt' => new \DateTime('2016-05-24'),
                'updateAt' => new \DateTime('2016-05-24'),
            ],
            [
                'title' => 'Hades',
                'description' => 'Un jeu de roguelike développé par Supergiant Games où vous incarnez Zagreus, le fils de Hadès, tentant de s\'échapper des Enfers.',
                'price' => '24.99',
                'releaseDate' => new \DateTime('2020-09-17'),
                'genre' => 'Roguelike',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-hades.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=lt_lX8q0ltI',
                'createdAt' => new \DateTime('2020-09-17'),
                'updateAt' => new \DateTime('2020-09-17'),
            ],
            [
                'title' => 'Celeste',
                'description' => 'Un jeu de plateforme indépendant acclamé par la critique, développé par Maddy Makes Games, centré sur l\'escalade d\'une montagne.',
                'price' => '19.99',
                'releaseDate' => new \DateTime('2018-01-25'),
                'genre' => 'Platformer',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-celeste.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=eI4lWvgR5Kw',
                'createdAt' => new \DateTime('2018-01-25'),
                'updateAt' => new \DateTime('2018-01-25'),
            ],
            [
                'title' => 'Fortnite',
                'description' => 'Un jeu de bataille royale développé par Epic Games, connu pour son mode de jeu compétitif et son style artistique unique.',
                'price' => '0.00',
                'releaseDate' => new \DateTime('2017-07-25'),
                'genre' => 'Battle Royale',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-fortnite.webp',
                'trailerUrl' => 'https://www.youtube.com/watch?v=2S-1CG0g2pA',
                'createdAt' => new \DateTime('2017-07-25'),
                'updateAt' => new \DateTime('2017-07-25'),
            ],
            [
                'title' => 'The Elder Scrolls V: Skyrim',
                'description' => 'Jeu de rôle en monde ouvert développé par Bethesda Game Studios, connu pour son immense monde et ses nombreuses quêtes.',
                'price' => '39.99',
                'releaseDate' => new \DateTime('2011-11-11'),
                'genre' => 'RPG',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-skyrim.webp',
                'trailerUrl' => 'https://www.youtube.com/watch?v=K4pNf0djNsk',
                'createdAt' => new \DateTime('2011-11-11'),
                'updateAt' => new \DateTime('2011-11-11'),
            ],
            [
                'title' => 'Among Us',
                'description' => 'Jeu de déduction sociale développé par InnerSloth, où les joueurs doivent découvrir les imposteurs parmi l\'équipage.',
                'price' => '4.99',
                'releaseDate' => new \DateTime('2018-06-15'),
                'genre' => 'Social Deduction',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-among-us.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=Jf2y-1eoF5s',
                'createdAt' => new \DateTime('2018-06-15'),
                'updateAt' => new \DateTime('2018-06-15'),
            ],
            [
                'title' => 'Stardew Valley',
                'description' => 'Jeu de simulation de ferme développé par ConcernedApe, où les joueurs gèrent leur propre ferme et interagissent avec les habitants d\'un village.',
                'price' => '14.99',
                'releaseDate' => new \DateTime('2016-02-26'),
                'genre' => 'Simulation',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-stardew-valley.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=F12qZhK3kN0',
                'createdAt' => new \DateTime('2016-02-26'),
                'updateAt' => new \DateTime('2016-02-26'),
            ],
            [
                'title' => 'Half-Life 2',
                'description' => 'Un jeu de tir à la première personne développé par Valve Corporation, célèbre pour son histoire immersive et ses mécanismes de jeu innovants.',
                'price' => '9.99',
                'releaseDate' => new \DateTime('2004-11-16'),
                'genre' => 'FPS',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-half-life-2.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=wN0f3O8NqXQ',
                'createdAt' => new \DateTime('2004-11-16'),
                'updateAt' => new \DateTime('2004-11-16'),
            ],
            [
                'title' => 'Bioshock Infinite',
                'description' => 'Un jeu de tir à la première personne développé par Irrational Games, connu pour son histoire captivante et son cadre unique.',
                'price' => '29.99',
                'releaseDate' => new \DateTime('2013-03-26'),
                'genre' => 'FPS',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-bioshock-infinite.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=7q4A8m8wa14',
                'createdAt' => new \DateTime('2013-03-26'),
                'updateAt' => new \DateTime('2013-03-26'),
            ],
            [
                'title' => 'Hollow Knight',
                'description' => 'Un jeu d\'action-aventure développé par Team Cherry, connu pour son monde riche et ses mécaniques de jeu de plateforme.',
                'price' => '14.99',
                'releaseDate' => new \DateTime('2017-02-24'),
                'genre' => 'Metroidvania',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-hollow-knight.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=Z49G2Q6gE7A',
                'createdAt' => new \DateTime('2017-02-24'),
                'updateAt' => new \DateTime('2017-02-24'),
            ],
            [
                'title' => 'Portal 2',
                'description' => 'Un jeu de puzzle développé par Valve Corporation, célèbre pour ses mécanismes de jeu basés sur des portails et son humour unique.',
                'price' => '19.99',
                'releaseDate' => new \DateTime('2011-04-18'),
                'genre' => 'Puzzle',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-portal-2.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=8k1J8b2btgE',
                'createdAt' => new \DateTime('2011-04-18'),
                'updateAt' => new \DateTime('2011-04-18'),
            ],
            [
                'title' => 'Persona 5',
                'description' => 'Un jeu de rôle japonais développé par Atlus, connu pour son histoire captivante et son style artistique distinctif.',
                'price' => '59.99',
                'releaseDate' => new \DateTime('2016-09-15'),
                'genre' => 'RPG',
                'platform' => 'PlayStation 4',
                'coverImage' => '/images/CoverGame/cover-persona-5.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=CTb_M-QwF0I',
                'createdAt' => new \DateTime('2016-09-15'),
                'updateAt' => new \DateTime('2016-09-15'),
            ],
            [
                'title' => 'Animal Crossing: New Horizons',
                'description' => 'Un jeu de simulation de vie développé par Nintendo, où les joueurs peuvent personnaliser leur île et interagir avec les villageois.',
                'price' => '59.99',
                'releaseDate' => new \DateTime('2020-03-20'),
                'genre' => 'Simulation',
                'platform' => 'Nintendo Switch',
                'coverImage' => '/images/CoverGame/cover-animal-crossing.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=ahqZsck6tDQ',
                'createdAt' => new \DateTime('2020-03-20'),
                'updateAt' => new \DateTime('2020-03-20'),
            ],
            [
                'title' => 'Sekiro: Shadows Die Twice',
                'description' => 'Un jeu d\'action-aventure développé par FromSoftware, célèbre pour ses mécaniques de combat difficiles et son cadre inspiré du Japon féodal.',
                'price' => '59.99',
                'releaseDate' => new \DateTime('2019-03-22'),
                'genre' => 'Action',
                'platform' => 'PlayStation 4',
                'coverImage' => '/images/CoverGame/cover-sekiro.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=tqF7T9XcU7Y',
                'createdAt' => new \DateTime('2019-03-22'),
                'updateAt' => new \DateTime('2019-03-22'),
            ],
            [
                'title' => 'Dark Souls III',
                'description' => 'Un jeu de rôle d\'action développé par FromSoftware, connu pour sa difficulté élevée et son ambiance sombre.',
                'price' => '29.99',
                'releaseDate' => new \DateTime('2016-03-24'),
                'genre' => 'RPG',
                'platform' => 'PlayStation 4',
                'coverImage' => '/images/CoverGame/cover-dark-souls-3.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=bLBW9zFJkmc',
                'createdAt' => new \DateTime('2016-03-24'),
                'updateAt' => new \DateTime('2016-03-24'),
            ],
            [
                'title' => 'Divinity: Original Sin 2',
                'description' => 'Un jeu de rôle développé par Larian Studios, célèbre pour ses mécaniques de jeu profondes et son histoire riche.',
                'price' => '39.99',
                'releaseDate' => new \DateTime('2017-09-14'),
                'genre' => 'RPG',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-divinity-2.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=V3M4KXkYWFk',
                'createdAt' => new \DateTime('2017-09-14'),
                'updateAt' => new \DateTime('2017-09-14'),
            ],
            [
                'title' => 'Rocket League',
                'description' => 'Un jeu de sport automobile développé par Psyonix, où les joueurs contrôlent des voitures et jouent au football.',
                'price' => '19.99',
                'releaseDate' => new \DateTime('2015-07-07'),
                'genre' => 'Sport',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-rocket-league.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=V1jhTMm1bAI',
                'createdAt' => new \DateTime('2015-07-07'),
                'updateAt' => new \DateTime('2015-07-07'),
            ],
            [
                'title' => 'Death Stranding',
                'description' => 'Jeu d\'action-aventure développé par Kojima Productions, connu pour son approche unique du genre et son univers intrigant.',
                'price' => '59.99',
                'releaseDate' => new \DateTime('2019-11-08'),
                'genre' => 'Action',
                'platform' => 'PlayStation 4',
                'coverImage' => '/images/CoverGame/cover-death-stranding.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=ZFlbhS2OP2o',
                'createdAt' => new \DateTime('2019-11-08'),
                'updateAt' => new \DateTime('2019-11-08'),
            ],
            [
                'title' => 'Dishonored 2',
                'description' => 'Jeu d\'action-aventure avec des éléments furtifs développé par Arkane Studios, connu pour son gameplay flexible et son monde immersif.',
                'price' => '29.99',
                'releaseDate' => new \DateTime('2016-11-11'),
                'genre' => 'Action',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-dishonored-2.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=dGccML3OrfQ',
                'createdAt' => new \DateTime('2016-11-11'),
                'updateAt' => new \DateTime('2016-11-11'),
            ],
            [
                'title' => 'Nier: Automata',
                'description' => 'Un jeu de rôle d\'action développé par PlatinumGames, connu pour son récit profond et ses mécanismes de jeu uniques.',
                'price' => '39.99',
                'releaseDate' => new \DateTime('2017-03-07'),
                'genre' => 'RPG',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-nier-automata.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=JggD7Qij1z4',
                'createdAt' => new \DateTime('2017-03-07'),
                'updateAt' => new \DateTime('2017-03-07'),
            ],
            [
                'title' => 'Terraria',
                'description' => 'Un jeu de sandbox en 2D développé par Re-Logic, célèbre pour son monde ouvert et ses nombreuses mécaniques de jeu.',
                'price' => '9.99',
                'releaseDate' => new \DateTime('2011-05-16'),
                'genre' => 'Sandbox',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-terraria.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=v63x5sgdj3U',
                'createdAt' => new \DateTime('2011-05-16'),
                'updateAt' => new \DateTime('2011-05-16'),
            ],
            [
                'title' => 'Superhot',
                'description' => 'Un jeu de tir à la première personne où le temps ne passe que lorsque le joueur se déplace, développé par SUPERHOT Team.',
                'price' => '24.99',
                'releaseDate' => new \DateTime('2016-02-25'),
                'genre' => 'Shooter',
                'platform' => 'PC',
                'coverImage' => '/images/CoverGame/cover-superhot.jpeg',
                'trailerUrl' => 'https://www.youtube.com/watch?v=tnDfxo2XP2M',
                'createdAt' => new \DateTime('2016-02-25'),
                'updateAt' => new \DateTime('2016-02-25'),
            ],
        ];

        // Création des objets Game et persistance
        foreach ($games as $gameData) {
            $game = new Game();
            $game->setTitle($gameData['title'])
                ->setDescription($gameData['description'])
                ->setPrice($gameData['price'])
                ->setReleaseDate($gameData['releaseDate'])
                ->setGenre($gameData['genre'])
                ->setPlatform($gameData['platform'])
                ->setCoverImage($gameData['coverImage'])
                ->setTrailerUrl($gameData['trailerUrl'])
                ->setCreatedAt($gameData['createdAt'])
                ->setUpdateAt($gameData['updateAt']);

            $randomDeveloper = $developerEntities[array_rand($developerEntities)];
            $game->setDeveloper($randomDeveloper);


            $manager->persist($game);
        }

        $manager->flush();
    }
}
