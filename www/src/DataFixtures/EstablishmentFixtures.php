<?php

namespace App\DataFixtures;

use App\Entity\Establishment;
use App\Entity\Conference;
use App\Entity\Widget;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EstablishmentFixtures extends Fixture
{
    const NB_ESTABLISHMENT = 30;
    const DEMO_DOMAIN = 'demo.tekmedias.com';

    const conferencesImages = [
        'placeholder.png',
        '515-600x600.jpeg',
        '357-600x600.jpeg',
        '454-600x600.jpeg',
        '144-600x600.jpeg',
        '157-600x600.jpeg',
        '861-600x600.jpeg',
        '401-600x600.jpeg',
        '397-600x600.jpeg',
        '704-600x600.jpeg',
        '482-600x600.jpeg',
        '916-600x600.jpeg',
        '239-600x600.jpeg',
        '418-600x600.jpeg',
        '858-600x600.jpeg',
        '553-600x600.jpeg',
        '1051-600x600.jpeg',
        '406-600x600.jpeg',
        '177-600x600.jpeg',
        '175-600x600.jpeg',
        '176-600x600.jpeg',
    ];

    /*

     const establishmentsList = array (
        0 =>
            array (
                0 => 'nom_etablissements',
                1 => 'url',
                2 => 'adresse_etablissements',
                3 => 'code_postal',
                4 => 'ville',
            ),
        1 =>
            array (
                0 => 'Centrale Marseille',
                1 => 'https://www.centrale-marseille.fr/',
                2 => '38 rue Frédéric-Joliot-Curie',
                3 => '13451',
                4 => 'Marseille CEDEX 13',
            ),
        2 =>
            array (
                0 => 'École nationale supérieure d\'architecture de Paris-La Villette',
                1 => 'http://www.paris-lavillette.archi.fr/',
                2 => '144  RUE DE FLANDRE',
                3 => '75019',
                4 => 'PARIS',
            ),
        3 =>
            array (
                0 => 'École supérieure d\'ingénieurs des travaux de la construction de Metz',
                1 => 'http://www.esitc-metz.com/',
                2 => '6 rue Marconi',
                3 => '57070',
                4 => 'Metz',
            ),
        4 =>
            array (
                0 => 'Institut supérieur d\'électronique de Paris',
                1 => 'https://www.isep.fr/',
                2 => '28 rue Notre-Dame-des-Champs',
                3 => '75006',
                4 => 'Paris',
            ),
        5 =>
            array (
                0 => 'Institut supérieur du bâtiment et des travaux publics',
                1 => 'https://www.isba.fr/',
                2 => '5 RUE ENRICO FERMI',
                3 => '13453',
                4 => 'MARSEILLE CEDEX 13',
            ),
        6 =>
            array (
                0 => 'Neoma Business School',
                1 => 'https://www.neoma-bs.fr/',
                2 => '1 rue du Maréchal Juin',
                3 => '76130',
                4 => 'Mont Saint Aignan',
            ),
        7 =>
            array (
                0 => 'Université Claude Bernard - Lyon 1',
                1 => 'http://www.univ-lyon1.fr/',
                2 => '43 boulevard du 11 Novembre 1918',
                3 => '69622',
                4 => 'VilleurbanneCEDEX',
            ),
        8 =>
            array (
                0 => 'Université Clermont Auvergne',
                1 => '',
                2 => '49 boulevard François Mitterrand',
                3 => '63001',
                4 => 'Clermont-Ferrand CEDEX 1',
            ),
        9 =>
            array (
                0 => 'ECAM-EPMI',
                1 => 'http://www.epmi.fr/',
                2 => '13 boulevard de l\'Hautil',
                3 => '95092',
                4 => 'Cergy-Pontoise CEDEX',
            ),
        10 =>
            array (
                0 => 'École nationale supérieure d\'ingénieurs de Caen',
                1 => 'http://www.ensicaen.fr/',
                2 => '6 boulevard Maréchal Juin',
                3 => '14050',
                4 => 'Caen CEDEX 4',
            ),
        11 =>
            array (
                0 => 'École nationale supérieure Louis Lumière',
                1 => 'http://www.ens-louis-lumiere.fr/',
                2 => '20 rue Ampère',
                3 => '93200',
                4 => 'Saint-Denis',
            ),
        12 =>
            array (
                0 => 'École supérieure des technologies industrielles avancées',
                1 => 'http://www.estia.fr/',
                2 => '90 allée Fauste d\'Elhuyar',
                3 => '64210',
                4 => 'Bidart',
            ),
        13 =>
            array (
                0 => 'Vet Agro Sup',
                1 => 'http://www.vetagro-sup.fr/',
                2 => '1 avenue Bourgelat',
                3 => '69280',
                4 => 'Marcy-l\'Étoile',
            ),
        14 =>
            array (
                0 => 'Institut national du patrimoine',
                1 => 'http://www.inp.fr/',
                2 => '2 rue VIVIENNE',
                3 => '75002',
                4 => 'PARIS',
            ),
        15 =>
            array (
                0 => 'Université de Bordeaux',
                1 => 'https://www.u-bordeaux.fr/',
                2 => '351 cours de la Libération',
                3 => '33405',
                4 => 'Talence CEDEX',
            ),
        16 =>
            array (
                0 => 'Université de Tours',
                1 => 'https://www.univ-tours.fr/',
                2 => '60 rue du Plat d\'Étain',
                3 => '37020',
                4 => 'Tours CEDEX 1',
            ),
        17 =>
            array (
                0 => 'Université d\'Évry-Val-d\'Essonne',
                1 => 'https://www.univ-evry.fr/',
                2 => 'Boulevard François Mitterrand',
                3 => '91000',
                4 => 'Évry-Courcouronnes',
            ),
        18 =>
            array (
                0 => 'Université Toulouse Capitole',
                1 => 'http://www.ut-capitole.fr/',
                2 => '2 rue du Doyen-Gabriel-Marty',
                3 => '31042',
                4 => 'Toulouse CEDEX',
            ),
        19 =>
            array (
                0 => 'Audencia',
                1 => 'https://www.audencia.com/',
                2 => '8 route de la Jonelière',
                3 => '44312',
                4 => 'Nantes CEDEX 3',
            ),
        20 =>
            array (
                0 => 'CESI',
                1 => 'https://www.cesi.fr/',
                2 => '1 avenue du Général de Gaulle',
                3 => '92074',
                4 => 'Paris La Défense',
            ),
        21 =>
            array (
                0 => 'Institut National du Service Public',
                1 => 'https://www.ena.fr/',
                2 => '1 rue Sainte-Marguerite',
                3 => '67080',
                4 => 'Strasbourg CEDEX',
            ),
        22 =>
            array (
                0 => 'École nationale supérieure d\'architecture de Clermont-Ferrand',
                1 => 'http://www.clermont-fd.archi.fr/',
                2 => '85 rue du Docteur Bousquet',
                3 => '63100',
                4 => 'Clermont-Ferrand',
            ),
        23 =>
            array (
                0 => 'École supérieure d\'agriculture',
                1 => 'https://www.groupe-esa.com/',
                2 => '55 RUE RABELAIS',
                3 => '49007',
                4 => 'ANGERS CEDEX 01',
            ),
        24 =>
            array (
                0 => 'École supérieure d\'arts et médias de Caen - Cherbourg',
                1 => 'http://www.esam-c2.fr/',
                2 => '17  COURS CAFFARELLI',
                3 => '14000',
                4 => 'CAEN',
            ),
        25 =>
            array (
                0 => 'Burgundy School of Business',
                1 => 'https://www.bsb-education.com/',
                2 => '29 rue Sambin',
                3 => '21006',
                4 => 'Dijon CEDEX',
            ),
        26 =>
            array (
                0 => 'ESCP Business School',
                1 => 'https://escp.eu/fr',
                2 => '3 RUE ARMAND MOISANT',
                3 => '75015',
                4 => 'PARIS CEDEX 11',
            ),
        27 =>
            array (
                0 => 'Hautes études d\'ingénieur',
                1 => 'https://www.hei.fr/',
                2 => '13 rue de Toul',
                3 => '59014',
                4 => 'Lille CEDEX',
            ),
        28 =>
            array (
                0 => 'IPAG Business School',
                1 => 'https://www.ipag.fr/',
                2 => '184 BOULEVARD ST GERMAIN',
                3 => '75006',
                4 => 'PARIS',
            ),
        29 =>
            array (
                0 => 'Muséum national d\'histoire naturelle',
                1 => 'http://www.mnhn.fr/fr',
                2 => '57 rue Cuvier',
                3 => '75005',
                4 => 'PARIS',
            ),
        30 =>
            array (
                0 => 'Université de Pau et des Pays de l\'Adour',
                1 => 'https://www.univ-pau.fr/',
                2 => 'Avenue de l\'Université',
                3 => '64012',
                4 => 'Pau CEDEX',
            ),
        31 =>
            array (
                0 => 'Université de Picardie Jules-Verne',
                1 => 'https://www.u-picardie.fr/',
                2 => 'Chemin du Thil',
                3 => '80025',
                4 => 'AMIENS CEDEX 1',
            ),
        32 =>
            array (
                0 => 'Université de technologie de Compiègne',
                1 => 'https://www.utc.fr/',
                2 => 'Rue du docteur Schweitzer',
                3 => '60203',
                4 => 'Compiègne CEDEX',
            ),
        33 =>
            array (
                0 => 'Université Paris sciences et lettres',
                1 => 'https://www.psl.eu/',
                2 => '60 rue Mazarine',
                3 => '75006',
                4 => 'Paris',
            ),
        34 =>
            array (
                0 => 'Avignon Université',
                1 => 'https://univ-avignon.fr/',
                2 => '74 rue Louis Pasteur',
                3 => '84029',
                4 => 'Avignon CEDEX 1',
            ),
        35 =>
            array (
                0 => 'Centre national des arts du cirque',
                1 => 'https://www.cnac.fr/',
                2 => '1 rue DU CIRQUE',
                3 => '51000',
                4 => 'CHALONS EN CHAMPAGNE',
            ),
        36 =>
            array (
                0 => 'École d\'ingénieurs des sciences aérospatiales',
                1 => 'http://www.elisa-aerospace.fr/',
                2 => '48 rue Raspail',
                3 => '2100',
                4 => 'Saint-Quentin',
            ),
        37 =>
            array (
                0 => 'École nationale supérieure d\'architecture de Toulouse',
                1 => 'http://www.toulouse.archi.fr/fr/index.html',
                2 => '83  RUE ARISTIDE MAILLOL',
                3 => '31106',
                4 => 'TOULOUSE CEDEX 1',
            ),
        38 =>
            array (
                0 => 'École nationale supérieure des arts décoratifs',
                1 => 'https://www.ensad.fr/',
                2 => '31 RUE D ULM',
                3 => '75240',
                4 => 'PARIS CEDEX 05',
            ),
        39 =>
            array (
                0 => 'École nationale supérieure des arts et techniques du théâtre',
                1 => 'http://www.ensatt.fr/',
                2 => '4 rue Sœur Bouvier',
                3 => '69322',
                4 => 'Lyon CEDEX 05',
            ),
        40 =>
            array (
                0 => 'Toulouse INP',
                1 => 'https://www.inp-toulouse.fr/',
                2 => '6 allée Emile Monso',
                3 => '31029',
                4 => 'Toulouse CEDEX 4',
            ),
        41 =>
            array (
                0 => 'Bordeaux INP',
                1 => 'https://www.ipb.fr/',
                2 => 'Avenue des facultés',
                3 => '33405',
                4 => 'Talence',
            ),
        42 =>
            array (
                0 => 'Institut protestant de théologie',
                1 => 'http://www.iptheologie.fr/index.php',
                2 => '83 boulevard Arago',
                3 => '75014',
                4 => 'Paris',
            ),
        43 =>
            array (
                0 => 'Université de Bourgogne',
                1 => 'http://www.u-bourgogne.fr/',
                2 => 'Esplanade Erasme',
                3 => '21078',
                4 => 'Dijon CEDEX',
            ),
        44 =>
            array (
                0 => 'Université de Guyane',
                1 => 'http://www.univ-guyane.fr/',
                2 => '2091 route Baduel',
                3 => '97337',
                4 => 'Cayenne CEDEX',
            ),
        45 =>
            array (
                0 => 'Brest Business School',
                1 => 'https://brest-bs.com/',
                2 => '2 avenue DE PROVENCE',
                3 => '29238',
                4 => 'BREST CEDEX 2',
            ),
        46 =>
            array (
                0 => 'ECAM Rennes Louis de Broglie',
                1 => 'http://www.ecam-rennes.fr/',
                2 => '2 contour Antoine de Saint Éxupéry',
                3 => '35170',
                4 => 'Bruz',
            ),
        47 =>
            array (
                0 => 'École de biologie industrielle',
                1 => 'https://ebi-edu.com/fr/',
                2 => '49 avenue de Genottes',
                3 => '95895',
                4 => 'Cergy CEDEX',
            ),
        48 =>
            array (
                0 => 'Arts et Métiers Sciences et Technologies',
                1 => 'https://artsetmetiers.fr/',
                2 => '151 boulevard de l\'hÃ´pital',
                3 => '75013',
                4 => 'Paris',
            ),
        49 =>
            array (
                0 => 'Facultés libres de l\'Ouest',
                1 => 'https://www.uco.fr/fr',
                2 => '3 place André Leroy',
                3 => '49008',
                4 => 'Angers CEDEX 01',
            ),
    );

    */

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($nbEstablishment = 1; $nbEstablishment <= self::NB_ESTABLISHMENT; $nbEstablishment++) {
            $establishment = new Establishment();
            if ($nbEstablishment === 1) {
                $establishment->setName('kodoteam');
                $establishment->setWebsite('https://www.kodotalks.com');
                $establishment->setIsApproved(true);
                $establishment->setIsPremium(true);
            } else {
                $establishment->setName($faker->company);
                $establishment->setWebsite($faker->url);
                $establishment->setIsApproved($faker->boolean(80));
                $establishment->setIsPremium($faker->boolean(20));

                $widget = new Widget();
                $widget->addEstablishment($establishment);
                $widget->setName('widget-' . $faker->slug(2));
                $widget->setToken(md5(uniqid(rand(), true)));
                if ($nbEstablishment === 2 || $nbEstablishment === 3) {
                    $widget->setDomainAllowed(self::DEMO_DOMAIN);
                }
                $manager->persist($widget);
            }

            // Add reference for the others fixtures
            $this->addReference('establishment_' . $nbEstablishment, $establishment);

            $manager->persist($establishment);

            // Create conference for this establishment
            if ($nbEstablishment !== 1) {
                for ($c = 1; $c < 11; $c++) {
                    $conference = new Conference();
                    $conference
                        ->setName($faker->company)
                        ->setLocation($faker->streetAddress)
                        ->setAuthor($faker->name)
                        ->setSpeakers($faker->name)
                        ->setEstablishment($establishment)
                        ->setLikes(mt_rand(0, 100))
                        ->setDate($faker->dateTimeBetween('-10 days', '+90 days'))
                        ->setExtract($faker->text)
                        ->setDescription($faker->text)
                        ->setUrl($faker->url)
                        ->setIsBroadcasted($faker->boolean(80))
                        ->setReplayUrl(null)
                        ->setImageName(self::conferencesImages[$faker->numberBetween(1, 8)])
                        ->setVideoName(null)
                        ->setIsShared($faker->boolean(50))
                        ->setIsBroadcasted($faker->boolean(90))
                        ->addCategory($this->getReference('category_' . $faker->numberBetween(1, 8)));

                    $manager->persist($conference);
                }
            }
        }

        $manager->flush();
    }
}
