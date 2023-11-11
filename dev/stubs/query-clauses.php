<?php

namespace Lipe\Lib\Query\Clause {

	trait Meta_Query_Trait {
		/**
		 * @return Clause_Interface<Meta_Query, static>
		 */
		public function meta_query() {
		}
	}

	trait Date_Query_Trait {
		/**
		 * @return Clause_Interface<Data_Query, static>
		 */
		public function date_query() {
		}
	}

	trait Tax_Query_Trait {
		/**
		 * @return Clause_Interface<Tax_Query, static>
		 */
		public function tax_query() {
		}
	}
}
