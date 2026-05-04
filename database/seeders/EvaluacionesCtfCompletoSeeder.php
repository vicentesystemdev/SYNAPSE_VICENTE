<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluacion;
use App\Models\Categoria;
use App\Models\Dificultad;
use App\Models\Periodo;
use App\Models\User;
use App\Models\IrtParametro;

class EvaluacionesCtfCompletoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Validar Categorías
        $categorias = [
            'RAZON' => Categoria::where('codigo_cat', 'RAZON')->first(),
            'ALGEBRA' => Categoria::where('codigo_cat', 'ALGEBRA')->first(),
            'CALCULO' => Categoria::where('codigo_cat', 'CALCULO')->first(),
            'LOGICA' => Categoria::where('codigo_cat', 'LOGICA')->first(),
        ];

        foreach ($categorias as $key => $cat) {
            if (!$cat) {
                $this->command->error("❌ Categoría $key no encontrada.");
                return;
            }
        }

        $periodo = Periodo::firstOrCreate(['nombre_per' => '2025-1'], ['gestion_per' => '2025', 'activo_per' => true]);
        $docente = User::role(['admin', 'docente'])->first();
        
        $getDifficulty = function($puntos) {
            if ($puntos <= 100) return [1, -2.0, 'Fácil'];
            if ($puntos <= 200) return [2, -1.0, 'Básico'];
            if ($puntos <= 300) return [3, 0.0,  'Intermedio'];
            if ($puntos <= 450) return [4, 1.0,  'Avanzado'];
            return [5, 2.0, 'Experto'];
        };

        // --- DEFINICIÓN DE FLAGS POR CATEGORÍA ---
        $secretosPorCategoria = [
            'RAZON'    => 'flag_web_master',
            'ALGEBRA' => 'flag_crypto_master',
            'CALCULO'  => 'flag_stego_master',
            'LOGICA' => 'flag_forens_master',
        ];

        $hashesPorCategoria = array_map(fn($s) => md5($s), $secretosPorCategoria);

        // --- RETOS ---
        // Se mantiene la estructura [Cat, Titulo, Puntos, Desc, URL]
        // El código abajo se encargará de fusionar Desc + URL
        $retos = [
            // RAZON
            ['RAZON', 'Debes oír todo lo que te dicen', 50, 'Hay reglas que siempre uno debe poner atención así como de los detalles de los mismos.', 'http://200.9.165.32:8091/'],
            ['RAZON', 'Robot', 100, 'Un robot que te llevará al futuro...', 'http://200.9.165.32:8817/'],
            ['RAZON', 'Cryptonews', 100, 'El futuro de las finanzas digitales está oculto a simple vista. Encuentra la clave entre las tendencias del día y descifra el código que libera el acceso al siguiente nivel. ¿Podrás descifrar lo que hoy acontece en el mercado? Autor: Rick C-25.', 'http://200.9.165.32:9234/'],
            ['RAZON', 'Jason necesita un Razonamiento Token', 180, 'Escondieron la flag en la ruta /administracion, y segun Jason, solo el usuario CITC_admin tiene la autorizacion para ver la flag. Si deseas ser un invitado, interactura con la ruta /login, ten en cuenta que no existen otras rutas. Autor: DCV', 'http://200.9.165.32:3000/'],
            ['RAZON', 'Navidad', 199, 'El desarrollador junior llamó desde su nuevo trabajo y nos comenta que nos dejó un mensaje de fin de año, revisamos los servidores donde tenía acceso y encontramos una página web con un árbol de navidad, pero no pudimos encontrar el mensaje, ¿nos ayudas?', 'http://200.9.165.32:8726/'],
            ['RAZON', 'Jagger-wisky-tequila', 200, 'Eres el nuevo administrador de sistemas de "El Resacón Controlado". Preocupados por la salud de sus clientes, los dueños han implementado un estricto sistema de verificación de edad. Sin embargo, un cliente anónimo ha reportado que algunos productos restringidos aparecen como "disponibles" para menores. Tu objetivo es encontrar la vulnerabilidad que permite eludir este control. Autor: Rick C-25', 'http://200.9.165.32:9982/'],
            ['RAZON', 'Adivina', 200, 'Adivina, adivinador, eres capaz de encontrar la solucion?', 'http://200.9.165.32:8217/'],
            ['RAZON', 'No oigas al gato', 200, 'El felino es un sistema extremadamente bueno de seguridad, y si detecta cosas raras no te dejará pasar. Obtiene la bandera. Autor: Looper', 'http://200.9.165.32:8052/'],
            ['RAZON', 'Programador Razonamiento Junior', 200, 'El Jefe contrato a su sobrino, Le dijo que desarrollara la aplicacion de la empresa. Autor: go2hack', 'http://200.9.165.32:8087/'],
            ['RAZON', 'Galletitas', 230, 'Las galletas a veces son buenas con cafe.', 'http://200.9.165.32:8655/'],
            ['RAZON', 'Fuentes', 250, 'Me encantan las fuentes de agua', 'http://200.9.165.32:8474/'],
            ['RAZON', 'Descuido desafortunado', 275, 'Después de preparar la página del CIDSI para Navidad, el profesional de seguridad informática te indica que tienes una vulnerabilidad que permite exposición de información y que debe ser solucionada inmediatamente. ¿Que vulnerabilidad tendrá?', 'http://200.9.165.32:8202'],
            ['RAZON', 'Fusión', 330, 'Contexto: Es tu primera chamba... Te asignan una tarea que consiste en revisar un código donde se encuentran variables fundamentales. Tu misión es encontrar la contraseña del formulario y confirmar que devuelve la página para completar los accesos al baúl de contraseñas. Mientras revisas el código, te das cuenta de que hay algo más en juego. Autor: Rick C-25', 'http://200.9.165.32:8108/'],
            ['RAZON', 'Des-python-yam', 330, 'Lo mismo de siempre: Diviertete en el Ciberespacio !!!!!!! ¿Lograras el acceso? Autor: F7ash', 'http://200.9.165.32:8807'],
            ['RAZON', 'Developer enojado', 450, 'No deberia decirte esto pero ... El flag esta escondido en el código fuente de la aplicación móvil, espera khe????', 'http://200.9.165.32:8355/'],

            // ALGEBRA
            ['ALGEBRA', 'Samuel', 50, 'Nuestro amigo nos dejo este mensaje al parecer trabaja ahí: -.-. . -. - .-. --- / -.. . / --. . ... - .. --- -. ...', null],
            ['ALGEBRA', 'Pase Perdido', 80, 'Pablito faltó a clases y quiere participar en la 4 Competencia de Seguridad Informática CIDSI, uno de sus docentes le dejo una pista, será que Pablito participa de la Competencia??? Pista hexadecimal: 494a55574b3354574d...', null],
            ['ALGEBRA', 'Tocino', 100, 'Puerco Araña nos dejo un mensaje en un idioma muy extraño. ¿Ayudaños a entendrlo por favor? AAABABAAAAABAAAABBBABAABAABBABAABBABAAAAAAAAAAABABABAAAAAAAAAAAABAAAAAAAABAABBABABBAA', null],
            ['ALGEBRA', 'Bases', 100, 'Esto es de cajon si sabes de que hablo lo resolveras rapido siempre hay que aprender las bases del encriptado. Asi que comienza.', 'https://drive.google.com/file/d/1CDRaicjEcSt4NUZFGF90zcZhSz7HtL3U/view'],
            ['ALGEBRA', 'Emperator Romano', 100, 'Este cifrado es tan basico que hay una ensalada en su nombre: fhvdu_uxohc', null],
            ['ALGEBRA', 'Rotamos si rotamos no', 100, 'Esto es otro de los cifrados de cajon espero lo resuelvas rapido: 638CK370A320638', null],
            ['ALGEBRA', 'Castillo Perdido', 110, 'En un mundo digital olvidado, se encuentra un castillo misterioso, envuelto en códigos y secretos. El explorador Wally ha encontrado un objeto desconocido. "¡Ayuda!", exclamó Wally, dejando caer el misterioso objeto antes de ser atrapado por las garras de .NET. Autor: Samuel Loza Ramirez', 'https://drive.google.com/file/d/1e_yHPwpKuT1BhGmIe8drs2xIxfxqopsO/view'],
            ['ALGEBRA', 'Movimientos', 150, 'Desempolvando los pasos desde los 90. (Ver imagen de referencia Dancing Men)', null],
            ['ALGEBRA', 'Segunda guerra mundial', 190, 'Al parece un soldado logro quitarle un mensaje al enemigo pero antes de morir dijo "solo rot rot". Eres capaz de ayudarle? parece algo muy importante 2_70?8?A?20A3208?259C70?:G32C7 Autor: by D4lPh0ne', null],
            ['ALGEBRA', 'Cazafantasmas', 200, 'Un cazafantasmas encontro el siguiente archivo de audio un viernes 13 y cree que esta embrujado porque anteriormente escuchaba voces al derecho y al reves, podras encontrar la Flag? Autor: 0xdcv', 'https://drive.google.com/file/d/1DgJJsXC7CDmdZFs8ysaXzrt1L3EYpeQN/view'],
            ['ALGEBRA', 'Un nuevo reto', 220, 'Lo clásico nunca falla, pero siempre se puede mejorar... Desentraña el mensaje: Ts eoykqrg Etlqk, qxfjxt lodhst, iq lorg qdhsoqdtfzt xlqrg q sg sqkug rt sq iolzgkoq... Autor: Warrior', 'https://drive.google.com/file/d/1MrY9IxMKyX_riyulP-pwQj3YlrKVhMCv/view'],
            ['ALGEBRA', 'Un giro desesperado', 280, 'Se extrajo información de la competencia nada mal para un principiante, mas bien la información se encuentra con password xD, descubrelo y gana la competencia. Nota: La información tendría un precio de 32.000 costa rican colones', 'https://drive.google.com/file/d/1dD04pTMHEjj_I2eFtGT82PVCdcWYPXyB/view'],
            ['ALGEBRA', 'Sopa de letras', 300, 'No hay nada como una sopa muy cargada de vitaminas: 00110100 01100101 00100000 00110100 00111001 00100000 00110010...', null],
            ['ALGEBRA', 'Algo le pasa a mi cabeza', 300, 'Me siento fatal de la cabeza: >+++++++++++[<+++++++++++>-]<-----.+.>+++++[<----->-]<+++.>++++[<++++>-]<--...', 'https://drive.google.com/file/d/1adHjI1TM4_dS4amEr6l3AO7qCZTZMBGB/view'],
            ['ALGEBRA', 'Álgebra del bueno', 300, 'Disfruta resolviendo: ++++++++++[>+>+++>+++++++>++++++++++<<<<-]>>>++++.-------.+++.++.++++++.++.++++++.--------------...', 'https://drive.google.com/file/d/10hNEMaFEX4RmjxZobQHc9FVnnxSc_YO8/view'],
            ['ALGEBRA', 'Ok?', 300, '¿Estas Ok? Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook. Ook...', 'https://drive.google.com/file/d/1IRF5gvz2dA7w4Y2yjf2IG3fYngToLvvq/view'],
            ['ALGEBRA', 'Redial', 350, 'Tu amigo te dejo un mensaje de audio.', 'https://drive.google.com/file/d/1-w9QTkgGk4nrcI0mbnI0YsGis6YSppe4/view'],
            ['ALGEBRA', 'TriTriTri', 360, 'Tres tristes tigres, tragaban trigo en un trigal, en tres tristes trastos, tragaban trigo tres tristes tigres.', 'https://drive.google.com/file/d/1kjzKNGVpBlceORn_lilZk6HZuh13Iiik/view'],
            ['ALGEBRA', 'Álgebra Avanzado', 500, 'Se crearon 2 archivos para un reto exigente de criptografía, está preparado exclusivamente para alumnos de universidades. Intenta resolverlo. ¿Podrás encontrar el mensaje que ocultan estos archivos? by 0xb3t0 and Anonymous', 'https://drive.google.com/file/d/1Cbkf3oYrEkTHBXOw1ZSsFke0AUNy2gEw/view'],
            ['ALGEBRA', 'Una vuelta más', 500, 'A Zeus se le antojó un helado con pasas al ron, pero el mensajero no llegaba, después de horas llego Hermes, pero estaba agotado de llevar tantos mensajes, entonces Zeus le dijo que se vaya a dar una vuelta más y que él también se compre otro helado del sabor que quiera. by 0xb3t0', null],
            ['ALGEBRA', 'Rubik', 600, 'En este momento talvez no tienes todos los retos resueltos, pero eso no significa que nunca lo harás. 87 87 65 87 80 65 71 89 65 88 444... by 0xb3t0', null],

            // CALCULO
            ['CALCULO', 'La hipotenusa', 70, 'y todos pensábamos que era bueno... pero en fin... la hipotenusa. Autor: 0x3lP4p1L0c0', 'https://drive.google.com/file/d/1E9hM1TZbjT0Zy0uSgdT04M_ApUAtvmnY/view'],
            ['CALCULO', 'Latin', 80, 'Muchas palabras provienen del latín, por ejemplo: GLADIUS - Espada IMPERIUM - Imperio. Peeeero tengo dudas con este último: ONIDNARODNOCUM Me ayudas???', null],
            ['CALCULO', 'Paisaje', 80, 'El paisaje de la fotografia adjunta participo en un evento a mejor fotografia, la cámara que la tomo utilizo 4K, quisimos adquirir una por su resolución, ayudanos a saber cual es la marca. Autor: Carlos Morales', null],
            ['CALCULO', 'Explotación de stenografía', 100, 'Se tiene escondida la flag en la bomba. Autor: Claudia Ureña', null],
            ['CALCULO', 'Iconografía galletaria', 100, 'El conjunto de imagenes de representacion de galletitas tienen caracer de visualización sin fondo representando estados y objetos. Autor: Claudia Ureña', 'https://drive.google.com/file/d/1HjPX7olD4PMkJLnsbCNHAdk3Ga7zhv4y/view'],
            ['CALCULO', 'New Hope', 100, 'Este mensaje se estaba transmitiendo en un canal de comunicación abierto. Sospechamos que de esta manera los rebeldes se están comunicando. Los investigadores afirman que existen mensajes ocultos en estas transmisiones. Ayúdanos a descubrir esos mensajes. Autor: gp', 'https://drive.google.com/file/d/1KC_osNRDLpAiNeJ7XQiOgzcQEVRGCOdY/view'],
            ['CALCULO', 'Filtros', 110, 'Filtros Filtros Filtros ... Autor: asciizofrenia5', 'https://drive.google.com/file/d/1B9G43Pngmb5COgTllNsTb582fLu7_VRU/view'],
            ['CALCULO', 'La llave de tu corazon', 140, 'Durante un pentest se hallo este archivo, pero no sabemos que hacer con ella, el hacker nos dijo que era una llave! pero es un hacker muy bromista :( Autor: Drayko Escobar', 'https://drive.google.com/file/d/1sugxLC1tkzBKezsORp_YvC06N7knAPky/view'],
            ['CALCULO', 'Mensaje de la naturaleza', 140, 'La naturaleza te deja un mensaje oculto ... solo el lenguaje de viejos servidores funciona para resolverlo algunas teclas estan mal... Autor: Franolig', 'https://drive.google.com/file/d/1oHlnA4-zi4SnFCNOzuz0kjAndUkh7WJ7/view'],
            ['CALCULO', 'Binary?', 190, 'No todo en la vida es binario... O si? P.D. La raiz cuadrada de 1369 es 37 Autor: gp', null],
            ['CALCULO', 'Ricardo en apuros', 240, 'Ricardo está tratando de ocultar una imagen de su amigo Benito. Aplicando sus habilidades de programación en python, escribió un programa para automatizar esta tarea, pero en el proceso perdió la imagen original. Él ahora necesita tu ayuda para recuperarla. ¿Podrás ayudarlo? Autor: asccizofrenia5', 'https://drive.google.com/file/d/1SRETFrXChYwGgAHTKp8Gc-gjgNSRft8L/view'],
            ['CALCULO', 'Encuentra la bandera', 200, 'La steganografía es el arte de esconder mensajes. Esta técnica de cifrado alternativo oculta un mensaje secreto, encerrándolo en un archivo ordinario. Autor: Claudia Ureña', null],
            ['CALCULO', 'Topografía', 300, 'La topografía de nuestro país es muy diversa, en la imagen adjunta lo podemos observar, o no?', null],
            ['CALCULO', 'The invisible flag', 300, 'Nos ha llegado esta imagen pero no sabemos qué significa. Hemos probado las técnicas básicas de stego y nada. ¿Sabrías decirnos de qué se trata?', null],
            ['CALCULO', 'Nested Frames', 350, 'Múltiples capas de imágenes denominadas atbash', 'https://drive.google.com/file/d/16shQU0p-ci3wLg69O19T2ZbPpdkIaQm9/view'],
            ['CALCULO', 'Musica', 500, 'Este sonido podria asustarte y dejarte sin dormir. Ten cuidado podrias enloquecer. by 0xb3t0', 'https://drive.google.com/file/d/1ZLbLEi20qSaAC5OE2kRbk4XdjjdnA5md/view'],
            ['CALCULO', 'Tic-Tac', 500, '...Preciso tiempo necesito ese tiempo que otros dejan abandonado porque les sobra o ya no saben que hacer con él tiempo en blanco en rojo en verde hasta en castaño oscuro no me importa el color cándido tiempo que yo no puedo abrir y cerrar como una puerta... Mario Benedetti', 'https://drive.google.com/file/d/1bWSJreTev3upiXLDdxVgZzZPz4qULEeT/view'],

            // LOGICA
            ['LOGICA', 'Captura de tráfico', 80, 'Durante un ataque se logro capturar el trafico de red, al parecer existen cosas interesantes.', 'https://drive.google.com/file/d/1tyBFiO6QLmU25nCMz7KvQO6dGjG1xM6e/view'],
            ['LOGICA', 'Pasajes a Qatar', 150, 'Nuestros agentes han descubierto que unos delicuentes han conseguido la manera de lavar dinero comprando pasajes en avion para el Mundial de Qatar utilizando criptomonedas. Lo primero que la fiscalia necesita conocer es cuantas transacciones en total fueron realizadas y de segundo necesitan cuantos tipos de criptomonedas estuvieron involucradas en total.', 'https://drive.google.com/file/d/1rGUl6zkXCphcceLrg2Sg2830_MNNnQxN/view'],
            ['LOGICA', 'Los 5 secretos de Juan', 190, 'A lo largo de los años, Juan ha desarrollado una obsesión con las combinaciones de 5 elementos. En este desafío, tendrás que desentrañar los secretos que ha dejado escondidos en los archivos. Autor: 3LH3ch1z3r0', null],
            ['LOGICA', 'Bof', 200, 'Si quieres una ayuda debes entender las operaciones bitwise.', 'https://drive.google.com/file/d/1uxo36B8fSgHqPSr_czmMibhMFDYOJH4V/view'],
            ['LOGICA', 'Qué Rollo', 250, '¿Una flag en un QR? Qué Rollo!!!', null],
            ['LOGICA', 'El secuestro del michi', 290, 'Secuestraron al gato de una persona importante (no diremos quien es por seguridad), ayúdalo a reunirse de nuevo con su dueño que lo extraña mucho. Autor:Fabian Rieral', 'https://drive.google.com/file/d/1dLFcdJGmI8Wb8vYUOJlSGcg9ZEOB0_5V/view'],
            ['LOGICA', 'Decapitado', 300, 'Hasta el momento parece que la guerra cibernética tiene consecuencias sólo virtuales, pero en esta ocasión, un agente ha preferido morir decapitado antes de revelar el secreto que esconde este archivo. ¿Serás capaz de obtenerlo tú solo?', 'https://drive.google.com/file/d/1o1KKnuRCV-UHSsYaMzakPZ_GEMh2Y3nt/view'],
            ['LOGICA', 'Ping me', 300, 'Te acaban de contratar en una empresa de ciberseguridad y estás en un SOC mirando el tráfico de red que se dirigía hacia fuera de la empresa cliente. Dicho tráfico, aunque parezca habitual, por alguna razón te hace sospechar... Demuéstrale a tu jefe que tienes vista de halcón.', 'https://drive.google.com/file/d/1EgcYLaJCo-iWQbfJsYAPgALdsQI2FQDy/view'],
            ['LOGICA', 'Discos-Horrocruxes', 300, 'Loid Forger, uno de los nombres de un espía experimentado, se ha infiltrado en el datacenter de una empresa. Él te ha suministrado 2 discos, y tu deber como experto en Linux es extraer información de ellos.', 'https://drive.google.com/file/d/1jwWL0Nf2GLoYGhoChA3laVcd2x9F5-hh/view'],
            ['LOGICA', 'El tesoro del muerto', 310, 'Se fue capturando mapas para encontrar el tesoro nadie lo encontro hasta ahora sera que tu eres el afortunado??? Encuentralo antes que alguien mas lo haga. by kM!D', 'https://drive.google.com/file/d/1LaRRrQ3b8UbnolTQL202FLdzhSvY7cxv/view'],
            ['LOGICA', 'Piensa', 330, 'El anverso de la moneda tiene un mensaje especial. Lo único que tienes que hacer es pensar con la cabeza y ordenar los cuadros.', 'https://docs.google.com/spreadsheets/d/1x4w1ugojbeaJ9emcARPruVaFeBBMgOSy/edit'],
            ['LOGICA', 'Pagos', 500, 'Al parecer uno de los empleados del Departamente de Tecnología del Sistema Aero Espacial Europeo ha estado robando y vendiendo informacion a China y Rusia. Como analista Senior del SOC/NOC, tu deber es conseguir cualquier información que nos lleve a la captura de este traidor.', 'https://drive.google.com/file/d/1eWfceuYmKL7YbaqY4Tvi7boZKgQkWDJi/view'],
        ];

        $totalCreadas = 0;

        foreach ($retos as [$catCode, $titulo, $puntos, $desc, $url]) {
            
            [$dificultadId, $b_irt, $label] = $getDifficulty($puntos);

            $flagHash = $hashesPorCategoria[$catCode]; 
            $flagOriginal = $secretosPorCategoria[$catCode];

            // ⚠️ MODIFICACIÓN: Si hay link, añadirlo al final de la descripción
            $descripcionFinal = $desc;
            if ($url) {
                $descripcionFinal .= "\n\nlink: $url";
            }

            $eval = Evaluacion::create([
                'titulo_eval'       => "{$catCode}: {$titulo}",
                'descripcion_eval'  => $descripcionFinal, // Descripción + Link
                'categoria_id'      => $categorias[$catCode]->id_cat,
                'dificultad_id'     => $dificultadId,
                'periodo_id'        => $periodo->id_per,
                'docente_user_id'   => $docente?->id,
                'puntaje_base_eval' => $puntos,
                'estado_eval'       => 2,
                'flag_hash_eval'    => null, 
                'solution_md5'      => $flagHash, 
                
                // ⚠️ MODIFICACIÓN: Campo archivo_adjunto vacío (NULL)
                'archivo_adjunto'   => null,

                'metadata_eval'     => json_encode([
                    'nivel_label'     => $label,
                    'external_url'    => $url, // Se mantiene en metadata por si el frontend lo usa
                    'flag_format'     => 'synapse{md5}',
                    'puntos_teoricos' => $puntos,
                    'flag_frase_original' => $flagOriginal 
                ]),
                'fecha_inicio_eval' => now()->subDays(10),
                'fecha_fin_eval'    => now()->addDays(60),
            ]);

            IrtParametro::create([
                'evaluacion_id'    => $eval->id_eval,
                'a_discriminacion' => 1.0 + ($dificultadId * 0.1), 
                'b_dificultad'     => $b_irt,
                'c_azar'           => 0.0
            ]);

            $totalCreadas++;
        }

        $this->command->info("✅ Se han creado {$totalCreadas} evaluaciones reales con descripciones completas.");
        $this->command->info("ℹ️ Flags agrupadas por categoría.");
    }
}