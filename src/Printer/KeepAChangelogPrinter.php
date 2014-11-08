<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Printer;

use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Item;
use Bigwhoop\Trellog\Model\Section;

class KeepAChangelogPrinter extends Printer
{
    /** {@inheritdoc} */
    protected $defaultOptions = [
        'title'                  => 'Change Log',
        'intro'                  => 'All notable changes to this project will be documented in this file.',
        'versions_whitelist'     => [],
        'versions_blacklist'     => [],
        'sections_whitelist'     => [],
        'sections_blacklist'     => [],
        'print_empty_sections'   => false,
        'empty_section_template' => '- Nothing',
    ];

    /**
     * @param string $key
     * @param array $whiteList
     * @param array $blackList
     * @return bool
     */
    private function checkWhiteAndBlackLists($key, array $whiteList, array $blackList)
    {
        if (in_array($key, $blackList)) {
            return false;
        }
        
        if (!empty($whiteList) && !in_array($key, $whiteList)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function printChangeLog(ChangeLog $changeLog)
    {
        $out = ['# ' . $this->getOption('title')];
        $out[] = $this->getOption('intro');
        $out[] = '';
        
        foreach ($changeLog->getEntries() as $entry) {
            $whiteList = $this->getOption('versions_whitelist');
            $blackList = $this->getOption('versions_blacklist');
            if (!$this->checkWhiteAndBlackLists($entry->version, $whiteList, $blackList)) {
                continue;
            }
            
            $entryOut = $this->printEntry($entry);
            
            if (!empty($entryOut)) {
                $out[] = $entryOut;
                $out[] = '';
            }
        }
        
        return join(PHP_EOL, $out);
    }
    
    /**
     * {@inheritdoc}
     */
    public function printEntry(Entry $entry)
    {
        $sectionOuts = [];
        foreach ($entry->getSections() as $section) {
            $whiteList = $this->getOption('sections_whitelist');
            $blackList = $this->getOption('sections_blacklist');
            if (!$this->checkWhiteAndBlackLists($section->name, $whiteList, $blackList)) {
                continue;
            }
            
            $sectionOut = $this->printSection($section);
            if (!empty($sectionOut)) {
                $sectionOuts[] = $sectionOut;
            }
        }
        
        if (empty($sectionOuts)) {
            return '';
        }
        
        $out = ['## ' . $this->formatVersion($entry->version) . ' - ' . $entry->date->format('Y-m-d')];
        $out[] = join(PHP_EOL . PHP_EOL, $sectionOuts);
        return join(PHP_EOL, $out);
    }
    
    /**
     * {@inheritdoc}
     */
    public function printSection(Section $section)
    {
        $items = $section->getItems();
        $isEmpty = count($items) == 0;
        
        if ($isEmpty && !$this->getOption('print_empty_sections')) {
            return '';
        }
        
        $out = ['### ' . $section->name];
        
        if ($isEmpty) {
            $out[] = $this->getOption('empty_section_template');
        } else {
            foreach ($items as $item) {
                $out[] = $this->printItem($item);
            }
        }
        
        return join(PHP_EOL, $out);
    }
    
    /**
     * {@inheritdoc}
     */
    public function printItem(Item $item)
    {
        return '- ' . $item->description;
    }
    
    /**
     * @param string $version
     * @return string
     */
    protected function formatVersion($version)
    {
        $matches = [];
        if (preg_match('|(\d+.\d+.\d+)|', $version, $matches)) {
            return $matches[1];
        }
        if (preg_match('|(\d+.\d+)|', $version, $matches)) {
            return $matches[1] . '.0';
        }
        
        return $version;
    }
}
