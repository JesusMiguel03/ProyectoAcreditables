<?php

namespace App\Traits;

trait DataTrait
{
    public function loadUsersData()
    {
        $users = [
            [
                'id' => 0,
                'name' => 'Coordinación',
                'nick' => 'root',
                'pass' => 'root'
            ],
            [
                'id' => 1,
                'name' => 'Fredy Alvarez',
                'nick' => 'prof1',
                'pass' => 'prof1'
            ],
            [
                'id' => 2,
                'name' => 'Anibal Cartas',
                'nick' => 'prof2',
                'pass' => 'prof2'
            ],
        ];
        return $users;
    }
    public function loadProfessorsData()
    {
        $professors = [
            [
                'id' => 0,
                'name' => 'Fredy Alvarez',
                'title' => 'Entrenador',
                'education' => 'Egresado de la UCV',
                'ubication' => 'Las Mercedes, Aragua',
                'skills' => 'Diseñador y programador web',
                'courses' => 'Actividad Física'
            ],
            [
                'id' => 1,
                'name' => 'Luis Perez',
                'title' => 'Programador',
                'education' => 'Egresado de la Havana',
                'ubication' => 'Caracas',
                'skills' => 'Ingeniero DevOps',
                'courses' => 'Ajedrez'
            ],
            [
                'id' => 2,
                'name' => 'Anibal Cartas',
                'title' => 'Ciberseguridad',
                'education' => 'Egresado de la UPTA FBF',
                'ubication' => 'La Mora, Aragua',
                'skills' => 'Programador backend',
                'courses' => 'Baloncesto'
            ],
            [
                'id' => 3,
                'name' => 'Cenaida Muñoz',
                'title' => 'Programadora fullstack',
                'education' => 'Egresada de la UCV',
                'ubication' => 'Turmero, Aragua',
                'skills' => 'Programadora mobile',
                'courses' => 'Coral'
            ],
            [
                'id' => 4,
                'name' => 'Cesar Perez',
                'title' => 'Diseñador web',
                'education' => 'Egresado de UBA',
                'ubication' => 'Cagua, Aragua',
                'skills' => 'Profesor y programador',
                'courses' => 'Fútbol'
            ],
            [
                'id' => 5,
                'name' => 'Anyerg Martínez',
                'title' => 'Inginiero en redes',
                'education' => 'Egresado de la UC',
                'ubication' => 'Valencia',
                'skills' => 'Analista de datos',
                'courses' => 'Panadería'
            ],
            [
                'id' => 6,
                'name' => 'Ivan Jimenez',
                'title' => 'Ingenier de software',
                'education' => 'Egresado de la UNEFA',
                'ubication' => 'El consejo, Aragua',
                'skills' => 'Diseñador web',
                'courses' => 'Primeros Auxilios'
            ]
        ];
        return $professors;
    }
    public function loadCoursesData()
    {
        $courses = [
            [
                'name' => 'Actividad Física',
                'quotes' => 40,
                'description' => 'Ejercitate un poco vago.... Venga, 1, 2, 3... 1, 2, 3',
                'longDescription' => 'Esta formación comprende el acercamiento de sus participantes a todas las manifestaciones de la actividad física y el deporte presentes en el país. Busca constituir un espacio para la promoción y la práctica de la actividad Física, deportiva, recreativa y de salud, así como otras áreas para la formación integral y holística de sus estudiantes. La importancia de actividades explicitas en el deporte y la educación enriquecen la personalidad y abren nuevas oportunidades, es así como la actividad física no se limita a la expresión de ideas y conceptos, sino que trasciende a las emociones y sensaciones que muchas veces no pueden expresarse por medio de palabras, tiene su base en la imaginación.'
            ],
            [
                'name' => 'Ajedrez',
                'quotes' => 30,
                'description' => 'El cuerpo no es lo único que debes entrenar.',
                'longDescription' => 'El ajedrez se presenta como un juego que puede convertirse en un instrumento educativo no convencional que apoyaría decididamente la labor académica , enriqueciendo al alumno con nuevos mecanismos de pensamiento que serán la base para arribar a la etapa operatoria formal. Además se descubre que el juego desarrolla la idea de cooperación (entre piezas), armonía y ponderación de posibilidades, valores absolutos y relativos, creatividad, estimula el desarrollo mental, aumenta su capacidad de calculo y raciocinio, desarrolla la imaginación, contribuye a fijar la atención, desarrolla la capacidad de abstracción, favorece el pensamiento lógico formal, forma el espíritu de investigación e inventiva, desarrolla la capacidad de observación y análisis en la esfera socio-afectiva, favorece el orden en la actividad, educa para el ocio a través de una actividad creativa, integra al grupo social, ejercita cualidades para superar problemas grupales y de tipo disciplinario y favorece las normas de cortesía que impone la practica del juego.'
            ],
            [
                'name' => 'Baloncesto',
                'quotes' => 20,
                'description' => 'Un deporte de altos, estadounidenses y faltas.',
                'longDescription' => 'La actividad acreditable Baloncesto pretende acercar y trabajar en equipo entre participantes ademas aporta múltiples beneficios a los que deseen disfrutar de este deporte. Y no solo por el propio ejercicio físico en sí, sino por los valores que conlleva. Los beneficios para el desarrollo y la formación de los jóvenes, como el fortalecimiento de la salud, así como el fomento de valores personales y sociales como el compromiso, la perseverancia, las responsabilidades individuales dentro del grupo, el trabajo en equipo, el respeto a las normas y a los demás y a aprender a competir. Además, aporta el desarrollo de recursos psicológicos como el cognitivo, la percepción de control, la autoconfianza, el autoconcepto y la autoestima y el autocontrol.',
            ],
            [
                'name' => 'Coral',
                'quotes' => 25,
                'description' => 'Gana nota cantando, nota aguda +1pt, gallo -1pt.',
                'longDescription' => 'El Programa de Expresión Musical se concibe como el arte de transmitir ideas y sentimientos por medio de la combinación de los sonidos; busca la expresión creativa efectiva e interactiva de los participantes a través de la voz y de instrumentos musicales, entre ellos: las corales, grupos instrumentales populares y académicos. A nivel musical, se denomina agrupación vocal, agrupación instrumental académica o popular a un conjunto de personas que interpretan una pieza de música , vocal o instrumental de manera coordinada, es el medio interpretativo colectivo de las obras musicales que requieren la intervención de la voz e instrumentos. Justificación Siendo la cultura, el vehículo del desarrollo de la humanidad, las instituciones se crecen a nivel humanístico, a nivel académico y a nivel cultural, con este tipo de actividades.',
            ],
            [
                'name' => 'Fútbol',
                'quotes' => 30,
                'description' => 'Para los fanáticos, su deporte favorito sin falta.',
                'longDescription' => 'Este programa no se ha diseñado para restar tiempo de clase, sino para complementar el esfuerzo de los educadores y potenciar los avances educativos. El acceso al fútbol, o a cualquier otro deporte, es un derecho humano universal. Se ha demostrado que el fútbol (y el deporte en general) resulta esencial para el bienestar de los más jóvenes y fomenta la adquisición de aptitudes y otros valores importantes para la vida .El fútbol puede mejorar la salud mental y física, aumentar el bienestar y reducir las probabilidades de padecer enfermedades en el futuro. Este dato es especialmente importante si se tiene en cuenta que los índices de actividad física están descendiendo en todo el mundo y las enfermedades asociadas a un determinado estilo de vida van en aumento.',
            ],
            [
                'name' => 'Panadería',
                'quotes' => 20,
                'description' => 'Panes, brownies, tortas, dulces e ideas para degustar.',
                'longDescription' => 'Este programa pretende incentivar a los jóvenes en el desarrollo de diferentes tareas necesarias en el trabajo diario de una panadería, desde el conocimiento de los ingredientes hasta la comercialización del pan. A través de esta actividad se fomenta el trabajo en equipo, el respeto por las tareas que realizan cada uno de los integrantes de la panadería y además se pretende lograr la identificación con un objetivo común, con el fin de progresar. Además del trabajo en equipo, respetarán reglas de convivencia ya que se desarrollan las actividades en un espacio común en el que se dividirán las tareas para la concreción de los objetivos planteados.',
            ],
            [
                'name' => 'Primeros Auxilios',
                'quotes' => 35,
                'description' => 'Desde salvar una vida hasta perderlas, el pack completo.',
                'longDescription' => 'Los Primeros Auxilios son las medidas que se toman inicialmente en un accidente. Son actividades fundamentales ante una urgencia, es necesario tratar los Primeros Auxilios con amplitud y rigor, merece la pena, más allá de la prevención y proporcionar conocimientos para poder realizar los Primeros Auxilios, siendo algo que todo el mundo debería poseer. Se trata de que el alumnado no se quede a nivel teórico con las pautas a seguir en los accidentes, sino que sepa realmente como aplicar estos conocimientos en una situación real, para lo cual, es necesario enseñarlo y evaluarlo.',
            ]
        ];
        return $courses;
    }
    public function loadStudentsData()
    {
        $db = [
            [
                'name' => 'Andres Blanco',
                'ide' => '30.190.199',
                'course' => 'Ajedrez',
                'year' => 'Trayecto 1',
            ],
            [
                'name' => 'Andrea Mendin',
                'ide' => '25.277.001',
                'course' => 'Panaderia',
                'year' => 'Trayecto 4',
            ],
            [
                'name' => 'Alex Gomez',
                'ide' => '27.659.340',
                'course' => 'Futbol',
                'year' => 'Trayecto 3',
            ],
            [
                'name' => 'Alejandra García',
                'ide' => '29.990.440',
                'course' => 'Baloncesto',
                'year' => 'Trayecto 1',
            ],
            [
                'name' => 'Karoline Betancourt',
                'ide' => '30.050.230',
                'course' => 'Ajedrez',
                'year' => 'Trayecto 3',
            ],
            [
                'name' => 'Michael Gomez',
                'ide' => '25.333.142',
                'course' => 'Futbol',
                'year' => 'Trayecto 2',
            ],
            [
                'name' => 'Julio Andrade',
                'ide' => '28.999.001',
                'course' => 'Primeros Auxilios',
                'year' => 'Trayecto 4',
            ],
        ];
        return $db;
    }
}
