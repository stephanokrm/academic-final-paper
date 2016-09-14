<?php

namespace Academic\Domain\Color;

class ColorHelper {

    public function getColorName($id) {
        switch ($id) {
            case 11:
                return 'Vermelho';
            case 10:
                return 'Verde';
            case 9:
                return 'Azul';
            case 8:
                return 'Cinza';
            case 7:
                return 'Ciano';
            case 6:
                return 'Laranja';
            case 5:
                return 'Amarelo';
            case 4:
                return 'Rosa';
            case 3:
                return 'Roxo';
            case 2:
                return 'Cerceta';
            case 1:
                return 'Azul Claro';
        }
    }

}
