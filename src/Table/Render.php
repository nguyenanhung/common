<?php
/**
 * @package    Fuel\Common
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Common\Table;

use Fuel\Common\Table;

/**
 * Uses a table structure built with Table to create HTML
 *
 * @package Fuel\Common
 *
 * @since 2.0
 */
abstract class Render
{
	/**
	 * Renders the given table into a string. Output depends on the subclass
	 *
	 * @param Table $table
	 *
	 * @return string
	 */
	public function renderTable(Table $table)
	{
		//Generate each row
		$rows = $this->buildRows($table);

		$headerRows = $this->buildHeaders($table);

		$footerRows = $this->buildFooters($table);

		return $this->container($table, $rows, $headerRows, $footerRows);
	}

	/**
	 * Renders the main body rows for the table
	 *
	 * @param Table $table
	 *
	 * @return array
	 */
	protected function buildRows(Table $table)
	{
		//Generate each row
		$rows = array();

		foreach ( $table->getRows() as $row )
		{
			//Build the cells for each row
			$cells = array();

			foreach ( $row as $cell )
			{
				$cells[] = $this->cell($cell);
			}

			$rows[] = $this->row($row, $cells);
		}

		return $rows;
	}

	/**
	 * Renders the header rows for the table
	 *
	 * @param Table $table
	 *
	 * @return array
	 */
	protected function buildHeaders(Table $table)
	{
		//Generate each row
		$rows = array();

		foreach ( $table->getHeaderRows() as $row )
		{
			//Build the cells for each row
			$cells = array();

			foreach ( $row as $cell )
			{
				$cells[] = $this->headerCell($cell);
			}

			$rows[] = $this->headerRow($row, $cells);
		}

		return $rows;
	}

	/**
	 * Renders the footer rows for the table
	 *
	 * @param Table $table
	 *
	 * @return array
	 */
	protected function buildFooters(Table $table)
	{
		//Generate each row
		$rows = array();

		foreach ( $table->getFooterRows() as $row )
		{
			//Build the cells for each row
			$cells = array();

			foreach ( $row as $cell )
			{
				$cells[] = $this->footerCell($cell);
			}

			$rows[] = $this->footerRow($row, $cells);
		}

		return $rows;
	}

	/**
	 * Should generate the container tag, eg: &lt;table&gt;
	 *
	 * @param Table $table
	 * @param array $rows
	 * @param array $headerRows
	 * @param array $footerRows
	 *
	 * @return mixed Should Ideally be a string that can be printed later
	 */
	protected abstract function container(
		Table $table,
		array $rows,
		array $headerRows,
		array $footerRows
	);

	/**
	 * Renders a normal Row
	 *
	 * @param Row   $row
	 * @param array $cells
	 *
	 * @return mixed Should ideally be a string that can be printed by container()
	 */
	protected abstract function row(Row $row, array $cells);

	/**
	 * Renders a header Row
	 *
	 * @param Row   $row
	 * @param array $cells
	 *
	 * @return mixed Should ideally be a string that can be printed by container()
	 */
	protected abstract function headerRow(Row $row, array $cells);

	/**
	 * Renders a footer Row
	 *
	 * @param Row   $row
	 * @param array $cells
	 *
	 * @return mixed Should ideally be a string that can be printed by
	 * container()
	 */
	protected abstract function footerRow(Row $row, array $cells);

	/**
	 * Renders a normal cell
	 *
	 * @param Cell
	 */
	protected abstract function cell(Cell $cell);

	/**
	 * Renders a header cell
	 *
	 * @param Cell
	 */
	protected abstract function headerCell(Cell $cell);

	/**
	 * Renders a footer cell
	 *
	 * @param Cell
	 */
	protected abstract function footerCell(Cell $cell);
}
