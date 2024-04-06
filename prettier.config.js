module.exports = {
    trailingComma: 'es5',
    tabWidth: 4,
    singleQuote: true,
    singleAttributePerLine: true,
    plugins: ['prettier-plugin-organize-attributes'],
    attributeGroups: ['$DEFAULT', '^data-'],
    attributeSort: 'ASC',
};
