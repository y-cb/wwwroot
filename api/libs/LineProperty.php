<?php
namespace lib;
//===================================================
// CLASS LineProperty
// Description: Holds properties for a line
//===================================================
class LineProperty {
    public $iWeight=1, $iColor='black', $iStyle='solid', $iShow=false;

    function __construct($aWeight=1,$aColor='black',$aStyle='solid') {
        $this->iWeight = $aWeight;
        $this->iColor = $aColor;
        $this->iStyle = $aStyle;
    }

    function SetColor($aColor) {
        $this->iColor = $aColor;
    }

    function SetWeight($aWeight) {
        $this->iWeight = $aWeight;
    }

    function SetStyle($aStyle) {
        $this->iStyle = $aStyle;
    }

    function Show($aShow=true) {
        $this->iShow=$aShow;
    }

    function Stroke($aImg,$aX1,$aY1,$aX2,$aY2) {
        if( $this->iShow ) {
            $aImg->PushColor($this->iColor);
            $oldls = $aImg->line_style;
            $oldlw = $aImg->line_weight;
            $aImg->SetLineWeight($this->iWeight);
            $aImg->SetLineStyle($this->iStyle);
            $aImg->StyleLine($aX1,$aY1,$aX2,$aY2);
            $aImg->PopColor($this->iColor);
            $aImg->line_style = $oldls;
            $aImg->line_weight = $oldlw;

        }
    }
}