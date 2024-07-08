<?php

/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright � 2022 KOVATZ.COM
*
*/

class Sitemap {
    
    private $gzip = false;
    private $isMultilingual = false; 
	private $writer;
	private $domain;
	private $path = ROOT_DIR;
	private $filename = 'sitemap';
	private $current_item = 0;
	private $current_sitemap = 0;

	const EXT = '.xml';
	const SCHEMA = 'http://www.sitemaps.org/schemas/sitemap/0.9';
    const MULTI_SCHEMA = 'http://www.w3.org/1999/xhtml';
	const DEFAULT_PRIORITY = 0.5;
	const ITEM_PER_SITEMAP = 50000;
	const SEPERATOR = '';
	const INDEX_SUFFIX = '';
    
    public function deleteOldSitemaps($status = false){
        if($status){
            foreach (glob(ROOT_DIR.'{sitemap,sitemap-index}*.xml',GLOB_BRACE) as $filename) {
                if(file_exists($filename))
                    unlink($filename);
            }
            foreach (glob(ROOT_DIR.'{sitemap,sitemap-index}*.xml.gz',GLOB_BRACE) as $filename) {
                if(file_exists($filename))
                   unlink($filename);
            }
        }
    }
    
	public function setMultilingual($status = true) {
		$this->isMultilingual = $status;
		return $this;
	}
    
	public function getMultilingual() {
		return $this->isMultilingual;
	}
    
	public function setGzip($status = true) {
		$this->gzip = $status;
		return $this;
	}
    
	public function getGzip() {
		return $this->gzip;
	}

	public function __construct($domain) {
		$this->setDomain($domain);
	}

	public function setDomain($domain) {
		$this->domain = $domain;
		return $this;
	}

	private function getDomain() {
		return $this->domain;
	}

	private function getWriter() {
		return $this->writer;
	}

	private function setWriter(\XMLWriter $writer) {
		$this->writer = $writer;
	}

	private function getPath() {
		return $this->path;
	}

	public function setPath($path) {
		$this->path = $path;
		return $this;
	}

	private function getFilename() {
		return $this->filename;
	}

	public function setFilename($filename) {
		$this->filename = $filename;
		return $this;
	}

	private function getCurrentItem() {
		return $this->current_item;
	}

	private function incCurrentItem() {
		$this->current_item = $this->current_item + 1;
	}

	private function getCurrentSitemap() {
		return $this->current_sitemap;
	}

	private function incCurrentSitemap() {
		$this->current_sitemap = $this->current_sitemap + 1;
	}

	private function startSitemap() {
		$this->setWriter(new \XMLWriter());
		if($this->getGzip()){
			$this->getWriter()->openMemory();
		} else {
    		if ($this->getCurrentSitemap()) {
    			$this->getWriter()->openURI($this->getPath() . $this->getFilename() . self::SEPERATOR . $this->getCurrentSitemap() . self::EXT);
    		} else {
    			$this->getWriter()->openURI($this->getPath() . $this->getFilename() . self::SEPERATOR . '0'. self::EXT);
    		}
        }
		$this->getWriter()->startDocument('1.0', 'UTF-8');
		$this->getWriter()->setIndent(true);
		$this->getWriter()->startElement('urlset');
		$this->getWriter()->writeAttribute('xmlns', self::SCHEMA);
        if($this->getMultilingual())
            $this->getWriter()->writeAttribute('xmlns:xhtml', self::MULTI_SCHEMA);
	}

	public function addItem($loc, $priority = self::DEFAULT_PRIORITY, $changefreq = NULL, $lastmod = NULL, $langCodes = array()) {
		if (($this->getCurrentItem() % self::ITEM_PER_SITEMAP) == 0) {
			if ($this->getWriter() instanceof \XMLWriter) {
				$this->endSitemap();
			}
			$this->startSitemap();
			$this->incCurrentSitemap();
		}
		$this->incCurrentItem();
		$this->getWriter()->startElement('url');
		$this->getWriter()->writeElement('loc', $this->getDomain() . $loc);
       
        if($this->getMultilingual()){
            foreach($langCodes as $bal_aji){
        		$this->getWriter()->startElement('xhtml:link');
                $this->getWriter()->writeAttribute("rel","alternate");
                $this->getWriter()->writeAttribute("hreflang",$bal_aji);
                $this->getWriter()->writeAttribute("href",$this->getDomain(). '/' . $bal_aji . $loc);
                $this->getWriter()->endElement();
            }
        }
        
		if($priority !== null)
			$this->getWriter()->writeElement('priority', $priority);
		if ($changefreq)
			$this->getWriter()->writeElement('changefreq', $changefreq);
		if ($lastmod)
			$this->getWriter()->writeElement('lastmod', $this->getLastModifiedDate($lastmod));
		$this->getWriter()->endElement();
		return $this;
	}

	private function getLastModifiedDate($date) {
		if (ctype_digit($date)) {
			return date('Y-m-d', $date);
		} else {
			$date = strtotime($date);
			return date('Y-m-d', $date);
		}
	}

	private function endSitemap() {
		if (!$this->getWriter()) {
			$this->startSitemap();
		}
		$this->getWriter()->endElement();
		$this->getWriter()->endDocument();
		if($this->getGzip()){
		    $filesCount = $this->getCurrentSitemap() - 1;
			$filename = ($filesCount)
				? $this->getPath() . $this->getFilename() . self::SEPERATOR . $this->getCurrentSitemap() . self::EXT
				: $this->getPath() . $this->getFilename() . self::SEPERATOR . '0' . self::EXT;

			$file = gzopen($filename.'.gz', 'w');
			gzwrite($file, $this->getWriter()->outputMemory());
			gzclose($file);
		}
	}


	public function createSitemapIndex($loc, $lastmod = 'Today') {
		$this->endSitemap();
		$indexwriter = new \XMLWriter();
		$indexwriter->openURI($this->getPath() . $this->getFilename() . self::SEPERATOR . self::INDEX_SUFFIX . self::EXT);
		$indexwriter->startDocument('1.0', 'UTF-8');
		$indexwriter->setIndent(true);
		$indexwriter->startElement('sitemapindex');
		$indexwriter->writeAttribute('xmlns', self::SCHEMA);
		for ($index = 0; $index < $this->getCurrentSitemap(); $index++) {
			$indexwriter->startElement('sitemap');
			$indexwriter->writeElement('loc', $loc . $this->getFilename() . ($index ? self::SEPERATOR . $index : '0') . self::EXT . ($this->getGzip() ? '.gz' : ''));
			$indexwriter->writeElement('lastmod', $this->getLastModifiedDate($lastmod));
			$indexwriter->endElement();
		}
		$indexwriter->endElement();
		$indexwriter->endDocument();
	}

}
