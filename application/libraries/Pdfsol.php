<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdfsol extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
    public function Header()
    {
        // Get the current page break margin
        $bMargin = $this->getBreakMargin();

        // Get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;

        // Disable auto-page-break
        $this->SetAutoPageBreak(false, 0);

        // Restore the auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // Set the starting point for the page content
        $this->setPageMark();
    }

    public function changeTheDefault($tcpdflink)
    {
        $this->tcpdflink = $tcpdflink;
    }

    public function checkPageBreak($h = 0, $y = '', $addpage = true)
    {
        if (TCPDF_STATIC::empty_string($y)) {
            $y = $this->y;
        }
        $current_page = $this->page;
        if ((($y + $h) > $this->PageBreakTrigger) and ($this->inPageBody()) and ($this->AcceptPageBreak())) {
            if ($addpage) {
                //Automatic page break
                $x = $this->x;
                $this->AddPage($this->CurOrientation);
                $this->y = $this->tMargin;
                $oldpage = $this->page - 1;
                if ($this->rtl) {
                    if ($this->pagedim[$this->page]['orm'] != $this->pagedim[$oldpage]['orm']) {
                        $this->x = $x - ($this->pagedim[$this->page]['orm'] - $this->pagedim[$oldpage]['orm']);
                    } else {
                        $this->x = $x;
                    }
                } else {
                    if ($this->pagedim[$this->page]['olm'] != $this->pagedim[$oldpage]['olm']) {
                        $this->x = $x + ($this->pagedim[$this->page]['olm'] - $this->pagedim[$oldpage]['olm']);
                    } else {
                        $this->x = $x;
                    }
                }
            }
            return true;
        }
        if ($current_page != $this->page) {
            // account for columns mode
            return true;
        }
        return false;
    }
}
