const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

function requestToExternal( request ) {
	switch ( request ) {
        case '@wordpress/customize-preview':
            return [ 'wp', 'customize' ];
	}
}

function requestToHandle( request ) {
	switch ( request ) {
        case '@wordpress/customize-preview':
            return 'customize-preview';
	}
}

module.exports = {
    ...defaultConfig,
    plugins: [
		...defaultConfig.plugins.filter(
			( plugin ) =>
				plugin.constructor.name !== 'DependencyExtractionWebpackPlugin'
		),
        // https://github.com/WordPress/gutenberg/blob/98018e9460e512437b2201ae4f0b453c1fe36259/packages/dependency-extraction-webpack-plugin/README.md
        new DependencyExtractionWebpackPlugin( { requestToHandle, requestToExternal } )
    ],
};
