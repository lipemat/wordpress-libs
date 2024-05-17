import styles from './dropdown-terms.pcss';

type Props = {
	taxonomy: string;
	checkedOnTop: boolean;
};

const DropdownTerms = ( {}: Props ) => {
	return (
		<div className={styles.wrap}>
			#### START HERE ######

			Populate the Dropdown and Simple Terms components.
		</div>
	);
};

export default DropdownTerms;
