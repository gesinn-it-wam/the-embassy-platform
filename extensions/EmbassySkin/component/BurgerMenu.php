<?php


namespace Skins\Chameleon\Components;


class BurgerMenu extends Component {


	public function getHtml() {

		return "<input type=\"checkbox\" id=\"nav-trigger-home\" />
            <label class=\"nav-trigger\" for=\"nav-trigger-home\">
                <svg class=\"open-icon\" viewBox=\"0 0 20 12\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
                    <g id=\"icon-hamburguer\" fill=\"#678B91\">
                        <rect id=\"rectangle-03\" x=\"0\" y=\"0\" width=\"20\" height=\"2\"></rect>
                        <rect id=\"rectangle-02\" x=\"0\" y=\"5\" width=\"20\" height=\"2\"></rect>
                        <rect id=\"rectangle-01\" x=\"0\" y=\"10\" width=\"20\" height=\"2\"></rect>
                    </g>
                </svg>
                <svg class=\"close-icon\" viewBox=\"0 0 13 13\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
                    <g id=\"icon-cross\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">
                        <path d=\"M5.59597747,6.61789673 L1,2.0219017 L2.02195371,1 L6.61788827,5.59597552 L11.213817,1 L12.2350947,2.0215377 L7.6392066,6.61730295 L12.2357837,11.213921 L11.213882,12.2358227 L6.61727954,7.63920269 L2.0212777,12.2350817 L1,11.213921 L5.59597747,6.61789673 Z\" id=\"cross\" stroke=\"#000000\" fill=\"#000000\"></path>
                    </g>
                </svg>
            </label>";
	}
}