<?php
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class View {
    private $twig;
    private $data = [];

    public function __construct() {
        $loader = new FilesystemLoader(VIEWS_PATH);

        $this->twig = new Environment($loader, [
            'cache' => TWIG_DEBUG ? false : CACHE_PATH,
            'debug' => TWIG_DEBUG,
            'auto_reload' => true
        ]);

        if (TWIG_DEBUG) {
            $this->twig->addExtension(new DebugExtension());
        }

        // Globale Variablen für alle Templates
        $this->twig->addGlobal('base_url', BASE_URL);

        // Custom Filter hinzufügen (z.B. für DSA-spezifische Formatierung)
        $this->addCustomFilters();
    }

    private function addCustomFilters() {
        // Beispiel: Würfelwurf-Notation formatieren
        $this->twig->addFilter(new \Twig\TwigFilter('dice_notation', function ($value) {
            return preg_replace('/(\d+)d(\d+)/', '<span class="dice">$1W$2</span>', $value);
        }, ['is_safe' => ['html']]));

        // AP mit Tausendertrennzeichen
        $this->twig->addFilter(new \Twig\TwigFilter('ap_format', function ($value) {
            return number_format($value, 0, ',', '.');
        }));
    }

    public function render($template, $data = []) {

        if (!is_dir(VIEWS_PATH)) {
            die('VIEWS_PATH existiert nicht: ' . VIEWS_PATH);
        }

        try {
            echo $this->twig->render($template, $data);
        } catch (\Twig\Error\LoaderError $e) {
            die('Template nicht gefunden: ' . $e->getMessage());
        } catch (\Twig\Error\RuntimeError $e) {
            die('Template Fehler: ' . $e->getMessage());
        }
    }

    public function getTwig() {
        return $this->twig;
    }
}