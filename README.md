# Catalog Search Plugin for Omeka

A plugin for [Omeka][] that uses the subject field in an Omeka item to
generate links to searches in catalogs such as Archive Grid, the DPLA,
Google Books, Google Scholar, the Hathi Trust, JSTOR, the Library of
Congress, and WorldCat. This plugin was created for the [American
Converts Database][] but it is useful more generally. This plugin works
best if you use Omeka's [Library of Congress Suggest plugin][] to add
LoC authorities and vocabularies to your items.

Lincoln A. Mullen | lincoln@lincolnmullen.com | http://lincolnmullen.com

## Configuration

The plugin will not display catalog links unless your item has a Dublin
Core subject. The plugin will use only the first Dublin Core subject if
there are multiple subjects.

You can edit the query strings for the default catalog searches, or you
can add your own catalogs. Each catalog needs to have a `query  string`.
This `query string` is a URL to the catalog, with the query terms
replaced with the characters `%s`.

Example: Searching Google for the word `test` returns the URL
`https://www.google.com/search?q=test`, so the query string for Google
is `https://www.google.com/search?q=%s`.

This plugin uses the same format as Google Chrome's custom search
engines. See [Chrome's documentation][] or this [ProfHacker post][] for
a more thorough explanation.

## Examples

Here are a few items in the [American Converts Database][] that show how
the links work:

-   [Jane Minot Sedgwick][]
-   [Isaac Hecker][]
-   [Warder Cresson][]

## License

© 2013 Lincoln A. Mullen

This program is free software: you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the
Free Software Foundation, either version 3 of the License, or (at your
option) any later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.

You should have received a copy of the GNU General Public License along
with this program. If not, see http://www.gnu.org/licenses/.

  [Omeka]: http://omeka.org
  [American Converts Database]: http://americanconverts.org
  [Library of Congress Suggest plugin]: http://omeka.org/add-ons/plugins/library-of-congress-suggest/
  [Chrome's documentation]: http://support.google.com/chrome/bin/answer.py?hl=en&answer=95653
  [ProfHacker post]: http://chronicle.com/blogs/profhacker/how-to-hack-urls-for-faster-searches-in-your-browser/42304
  [Jane Minot Sedgwick]: http://americanconverts.org/items/show/5
  [Isaac Hecker]: http://americanconverts.org/items/show/3
  [Warder Cresson]: http://americanconverts.org/items/show/7
