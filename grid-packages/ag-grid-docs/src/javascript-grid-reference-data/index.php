<?php
$pageTitle = "ag-Grid Reference: Reference Data";
$pageDescription = "Core feature of ag-Grid supporting Angular, React, Javascript and more. One such feature is Reference Data. Use Reference Data for easier editing of data that uses reference data for display. For example, country codes e.g. {IE, UK, USA} with display values e.g. {Ireland, Great Britain, United States of America}). Version 20 is available for download now, take it for a free two month trial.";
$pageKeywords = "ag-Grid Value Handlers";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1>Reference Data</h1>

<p class="lead">
    This section describes two different strategies for managing reference data in your application. Both approaches
    implement the same grid example so they can be easily compared.
</p>

<note>
    The term <strong>Reference Data</strong> is used here in a general way to describe data which can be defined using
    a key / value pair relationship (e.g. <code>'tyt': 'Toyota'</code>). This data is typically static in nature, i.e.
    it is not expected to change between server requests.
</note>

<p>
    The examples contained within this section use the following reference data. Note that the data returned from
    the server only contains codes (keys) which must be mapped to names (values) for display purposes.
</p>

<?= createSnippet(<<<SNIPPET
// data from server
var rowData = [
    { make: 'tyt', exteriorColour: 'fg', interiorColour: 'bw', price: 35000 },
    { make: 'frd', exteriorColour: 'bw', interiorColour: 'cb', price: 32000 },
        ...
]

// supporting reference data
var carMappings = {
     'tyt': 'Toyota',
     'frd': 'Ford',
     'prs': 'Porsche',
     'nss': 'Nissan'
};

var colourMappings = {
     'cb': 'Cadet Blue',
     'bw': 'Burlywood',
     'fg': 'Forest Green'
};
SNIPPET
) ?>

<h2>Using Value Handlers</h2>

<p>
    Value Handlers can be used to map keys contained within the row data to their corresponding display values. This
    approach involves more coding but allows for different data formats and offers more flexibility managing the data.
</p>

<p>
    The main idea of this approach is to use a <code>valueFormatter</code> to convert the code (key) to a value which
    is displayed in the cell. Then use a <code>valueParser</code> to convert the name back to a code (key) when saving
    it down into the underlying data.
</p>

<?= createSnippet(<<<SNIPPET
{
    headerName: 'Make',
    field: 'make',
    cellEditor: 'agSelectCellEditor',
    cellEditorParams: {
        values: extractValues(carMappings)
    },
    valueFormatter: function (params) {
        // convert code to value
        return lookupValue(carMappings, params.value);
    },
    valueParser: function (params) {
        // convert value to code
        return lookupKey(carMappings, params.newValue);
    }
}
SNIPPET
) ?>

<note>
    When editing using Cell Editors it's important to ensure the underlying data is updated with the codes (keys) rather
    than the values that are displayed in the cells.
</note>

<p>
    When using the <code>TextCellEditor</code> with reference data, you may want to display the formatted text rather
    than the code. In this case you should also include the <code>useFormatter</code> property as follows:
</p>

<?= createSnippet(<<<SNIPPET
cellEditor: 'agTextCellEditor',
cellEditorParams: {
   useFormatter: true
}
SNIPPET
) ?>

<h3>Example: Value Handlers</h3>

<p>
    The following example demonstrates how <code>Value Handlers</code> can be combined to work with reference data:
</p>

<ul class="content">
    <li>
        <b>'Make' Column:</b> uses the built-in <code>'select'</code> Cell Editor. Mapped names are displayed in the
        dropdown list and selections are saved as <code>'make'</code> codes in the underlying data.
    </li>
    <li>
        <b>'Exterior Colour' Column:</b> uses the built-in <code>'richSelect'</code> Cell Editor. Mapped names are
        displayed in the dropdown list and selections are saved as <code>'colour'</code> codes in the underlying data.
    </li>
    <li>
        <b>'Interior Colour' Column:</b> uses a Text Cell Editor with <code>useFormatter=true</code>. Mapped
        names are displayed in the cells and edited values are saved as <code>'colour'</code> codes in the underlying
        data. (Note: a valid name must be entered.)
    </li>
    <li>
        <b>Set Filters:</b> display a list of names rather than codes.
    </li>
    <li>
        <b>'Price' Columns:</b> additionally demonstrate the use of <code>valueGetters</code> and <code>valueSetters</code>.
    </li>
</ul>

<?= grid_example('Value Handlers', 'ref-data-value-handler', 'generated', ['enterprise' => true, 'modules' => ['clientside', 'richselect', 'setfilter', 'menu', 'columnpanel']]) ?>

<h2>Using the 'refData' Property</h2>

<p>
    Here we present the same example but this time using the <code>refData</code> <code>ColDef</code> property. This
    approach requires less coding and is more straightforward, but might not be flexible enough for scenarios involving
    more complex reference data formats.
</p>

<p>
    All that is required with this approach is to specify the <code>refData</code> and the grid will take care of the
    rest, as shown below:
</p>

<?= createSnippet(<<<SNIPPET
{
    headerName: 'Make',
    field: 'make',
    cellEditor: 'agSelectCellEditor',
    cellEditorParams: {
       values: extractValues(carMappings)
    },
    refData: carMappings
}
SNIPPET
) ?>

<p>
    Like in the previous example using Value Handlers, where the underlying data contains codes, the grid will
    use the specified reference data to display the associated values in the cells and save down the codes (keys) in
    the data when editing.
</p>

<h3>Example: 'refData' Property</h3>

<p>
    The following example demonstrates how the <code>refData</code> property simplifies working with reference data:
</p>

<ul class="content">
    <li>
        <b>'Make' Column:</b> uses the built-in <code>'select'</code> Cell Editor with the <code>refData</code> property
        specified. Mapped names are displayed in the dropdown list and selections are saved as <code>'make'</code> codes
        in the underlying data.
    </li>
    <li>
        <b>'Exterior Colour' Column:</b> uses the built-in <code>'richSelect'</code> Cell Editor with the
        <code>refData</code> property specified. Mapped names are displayed in the dropdown list and selections are
        saved as <code>'colour'</code> codes in the underlying data.
    </li>
    <li>
        <b>'Interior Colour' Column:</b> uses a Text Cell Editor with the <code>refData</code> property specified.
        Mapped names are displayed in the cells and edited values are saved as <code>'colour'</code> codes in the
        underlying data. (Note: a valid name must be entered.)
    </li>
    <li>
        <b>Set Filters:</b> display a list of names rather than codes.
    </li>
    <li>
        <b>'Price' Columns:</b> additionally demonstrate the use of <code>valueGetters</code> and <code>valueSetters</code>.
    </li>
</ul>

<?= grid_example('Ref Data Property', 'ref-data-property', 'generated', ['enterprise' => true, 'modules' => ['clientside', 'richselect', 'setfilter', 'menu', 'columnpanel']]) ?>

<?php include '../documentation-main/documentation_footer.php';?>
