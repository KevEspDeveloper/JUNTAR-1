<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */



?>

<?php 

/**
 * Pequeño easter egg de diálogo estático.
 * No está listado en ningún lugar del sitio
 * Para ver el diálogo, ir al final de CertificadoController y descomentar la línea
 */

?>

<div class="container text-center">

    <p class="text-right">
        
    <?= Html::encode($fecha) ?>

    </p>

</div>

<div class="container px-5">

    <?php

    if ($nombre != "rosecrimson") {

        echo '<p class="text-center"> Nada que ver por aquí... ¿Acaso buscas algún CERTIFICADO CONTROLLER? </p>';

        
    }else{
        echo '<p class="text-left">
        ¿Qué pasa? ¿Estás bien?
        </p>

        <p class="text-right">
            Hola. No, la verdad no. Han sido muy raros todos estos días.
        </p>

        <p class="text-left">
            Te veo mal. Sé que intentas ocultar cómo te sientes, sonríes a los demás <br> como si nada pasara,
            pero te juro que esta vez sí se nota que algo te pasa. <br>
            Sé que apenas nos cononcemos, pero me preocupa verte así.
        </p>

        <p class="text-right">
            Ah... Sí. Todo empezó cuando ella me dejó. A partir de ese momento todo se vino <br> a pique. Disculpame. Estoy
            ocupado tratando de crear este formulario para firma digital o pierdo el año.
        </p>

        <p class="text-left">
            Insisto. Cuéntame. Yo también he sufrido varias cosas y no es bueno guardárselas. <br>
            Conmigo puedes confiar.
        </p>

        <p class="text-right">
            Será algo muy largo. ¿Estás segura?
        </p>

        <p class="text-left">
            ¡Por supuesto! Mira, me voy a sentar frente a ti, te escucharé todo lo que me digas.
        </p>

        <p class="text-right">
            Bueno. Gracias por escucharme...
        </p>
        <p class="text-right">
            La extraño. ¿Sabes? <br>
            Todo me pasa. En resúmen, Rose, mi carrera, mi familia, la pandemia, la cuarentena, la crisis, <br>
            que perderé la beca de ayuda económica porque me fue mal en todas las materias este año. <br>
            Y no hay vuelta atrás. <b>¡Cómo desearía ahora mismo que exista la máquina del tiempo!</b>
        </p>

        <p class="text-left">
            Wow... son muchas cosas... ¿Me describirías cada uno de esos items?
        </p>

        <p class="text-right">
            Bueno. Mientras pongo música de fondo. ¿Qué tal algo de rock? ¿Mr. Brightside?
        </p>

        <p class="text-left">
            Perfecto para la ocasión.
        </p>

        <p class="text-right">
            Y pensar que me fue tan bien  con Bootstrap... apenas pude generar estos diálogos... En fin. <br>
            Rose... sí, mi ex. Todos los días las personas terminan relaciones, pero esto dolió <br>
            demasiado. La amaba mucho, pero fui muy inmaduro. La hice sufrir mucho. Obviamente jamás <br>
            le haría daño a nadie, pero ella pensó que yo no la amaba lo suficiente. <br>
            Ahora que no estamos juntos me doy cuenta que la amo como jamás amé a nadie. <br>
            Aunque pasaron varios meses y se fue un poquito el dolor, ojalá pudiera decirle tantas cosas... <br>
            Por cierto, me ignora, jamás responde mis mensajes y está enamorada de un chico que conoció <br>
            en League of Legends. Y... ¿sabes qué? <b>Yo le enseñé a jugar ese juego.</b> Sí, jamás <br>
            me lo perdonaré. Y es algo irónico, y por eso me da tanto enojo. Mañana 10 es su cumpleaños, ¿sabes?
        </p>

        <p class="text-left">
            Ohhh... Se nota que te duele, la amabas mucho a Rose parece. Qué injusta situación. <br>
            Y después de tantos años juntos, ahora hace su vida y te ignora como si nada. Tampoco <br>
            hiciste algo como para que te odie... Tal vez está exagerando o quiere superarte a la fuerza.
        </p>

        <p class="text-right">
            No lo sé... Me está matando mi carrera... mis materias... ¡Tan bien que me iba! de verdad <br>
            pensé que me iba a recibir a fin de año, pero no será así. No entiendo nada, odio Yii2, odio <br>
            estudiar a distancia y la cuarentena. ¿Tienes idea de cuánto extraño subir la Buenos Aires hasta <br>
            la facultad después de bajarme del colectivo? O incluso, escuchar música mientras voy en él. <br>
            Era muy relajante y a veces divertido cuando el ritmo acompañaba mi estado de ánimo. <br>
            Y lo mejor, poder conocer gente, compañeros, amigos, hablar con los profesores y pasear por el campus...
        </p>

        <p class="text-right">
            A veces, mientras estudiaba en la cuarentena, me daban pequeños ataques de ansiedad que <br>
            no me dejaban concentrarme en nada. Obviamente desencadenado por la ruptura con Rose y la cuarentena. <br>
            Ah, y fueron 4 años y 4 meses para ser exactos. Y la última vez que la vi hasta ahora fue <br>
            un par de días antes del comienzo de la cuarentena, la tuve al lado en esa plaza, y como estaba <br>
            molesto no le dirigí la palabra... No sabía que sería la última vez que la iba a ver o poder decirle <br>
            que la amo. El 28 de marzo cortó conmigo <b>por Discord.</b> Cada vez que lo digo quiero llorar y reír <br>
            al mismo tiempo.
        </p>

        <p class="text-right">
            En fin, mi carrera. Bueno, lo que dije antes. Me fue peor imposible en este cuatrimestre. Las profes <br>
            no son el problema, hicieron lo que pudieron y hasta más, pobres... <br>
            Confiaron en mi para añadirle la firma digital a Juntar, que era algo importante y no pude hacer nada.
            <br>
            Y yo de verdad estaba ilusionado con Web Avanzada... Sería el primer framework que aprendería y ahora <br>
            terminé odiándolo. Incluso pienso dejar la carrera y hacer otra cosa, pero ya voy muy avanzado y el mundo <br>
            de la informática siento que es lo mío. Tal vez no programación en sí, pero sí diseño me gusta bastante.
        </p>

        <p class="text-left">
            * (Asiente con la cabeza y sonríe levemente) *
        </p>

        <p class="text-right">
            Ah, y uno de mis familiares está obligado a mudarse de la ciudad, y probablemente no lo vuelva a ver jamás.<br>
            No quiero hablar mucho de eso, pero en un principio me entristeció porque de verdad creía en él. <br>
            Pasé buen tiempo de mi infancia con él y aprendí cosas importantes como tocar la guitarra, pero bueno. <br>
        </p>

        <p class="text-right">
            Pocas veces me ha costado tanto estudiar como este año. Una parte de mi dice que debería perdonármelo <br>
            por lo duro que ha sido, pero la otra parte está profundamente decepcionada de mí. Podría haber hecho más. <br>
        </p>

        <p class="text-right">
            También me siento un inútil porque no puedo aprender bien a manejar. He salido muchas veces a practicar <br>
            pero sigo cometiendo errores y se me da mal manejar autos... Creo que jamás seré buen conductor. <br>
        </p>

        <p class="text-left">
            Hey, ahora mismo es invierno, pero en primavera podrían levantar la cuarentena aún más y tal vez vuelva algo de <br>
            las clases presenciales. Algo es algo, ¿no?
        </p>

        <p class="text-right">
            Sí, pero no sería lo mismo. Incluso mi carrera tal vez siga online, no lo sé. De todos modos no me ilusiona <br>
            mucho eso. Lo único bueno que habría de eso es que podría conocer a Lucie, una chica que conocí por Facebook <br>
            y vive cerca de Neuquén. <br>
            Tengo derecho a conocer gente, ¿no? 
        </p>

        <p class="text-left">
            Sí, por supuesto.
        </p>

        <p class="text-right">
            De todos modos el sólo pensar en que se libere el tránsito para ir a Neuquén me revuelve el estómago... <br>
            Eso significaría que Rose se encuentre con su enamorado...
        </p>

        <p class="text-left">
            Esto se está haciendo un poco largo. Deberíamos irnos ya. Pero, ¿Alguna otra cosa que quieras contarme?
        </p>

        <p class="text-right">
            Mmm yo me quedo... y no sé qué haré de ahora en más. Tendrá muchas consecuencias el no aprobar esta materia,<br>
             como perder la beca económica y un retraso de 1 año en la carrera. Y no sé en qué podría trabajar para tener algo de dinero. <br>
            Es muy complicado... Mi familia no es que esté en la mejor situación tampoco. 
        </p>

        <p class="text-right">
            Tal vez haga algún curso online sobre algún framework para sentir que aprendí algo este año. <br>
            Aunque trabajar de esto... lo veo muy difícil. <b>Todos saben muchísimo de todo esto...</b> yo a duras <br>
            penas puedo hacer una página web usando Bootstrap. ¿Cómo llegué hasta aquí?... Demonios. ¡Estoy muy decepcionado!
        </p>

        <p class="text-right">
            Desearía volver al 2018. Fue un punto de inflexión en el que se basó mi presente. Y no me gusta nada...
        </p>

        <p class="text-left">
            Tranquilo, perdónatelo. No puedes hacer nada al respecto ni contigo mismo o lo que hiciste, no seas tan duro. <br>
            Mira, tengo que irme. Entiendo que tengas más cosas que decirme, pero puedes mandarme un mensaje <br>
            luego. ¿Está bien?
        </p>

        <p class="text-right">
            Gracias amiga... Espero que nadie lea todo esto.
        </p>

        <p class="text-left">
            De nada. Suerte con tu presentación en la materia y ojalá no se enojen contigo. Y suerte en tus partidas. <br>
            ¡Lo bueno de <i>"tocar fondo"</i> es que a partir de ahí sólo se puede subir!
        </p>'
        ;
    }

    ?>


</div>
