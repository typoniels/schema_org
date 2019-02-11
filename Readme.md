# Schema.org for TYPO3

This extension is very easy to use. Simply install and include the delivered static template.

## Configuration

You can configure the schema data by using Setup-TypoScript. So, the default configuration looks like:

```typo3_typoscript
plugin.tx_schemaorg {
	settings {
		page {
			# context is not required
			# Find other types on:
			# http://schema.org/LocalBusiness
			type = ProfessionalService
			name = Your company name
			url = {$themes.configuration.baseurl}
			telephone = +49 12 34 56 78 0
			image {
				type = ImageObject
				url = https://www.../logo.svg
				caption = Your company name
			}
			address {
				type = PostalAddress
				streetAddress = Musterstrasse 123
				addressLocality = Musterstadt
				postalCode = 54321
			}
			geo {
				type = GeoCoordinates
				latitude = 51° 54' 15.48'' N
				longitude = 7° 38' 51.65'' E
			}
			# Opening hours
			openingHoursSpecification {
				type = OpeningHoursSpecification
				dayOfWeek {
					# Builds a JSON array into node dayOfWeek
					ARRAY = Monday,Tuesday,Wednesday,Thursday,Friday
				}
				opens = 09:00
				closes = 21:00
			}
			# Contact
			contactPoint {
				type = ContactPoint
				telephone = +49 12 34 56 78 0
				# contact types for phone numbers:
				# https://developers.google.com/search/docs/data-types/corporate-contacts
				contactType = customer service
			}
		}
	}
}
```

For your own schema data, simply modify the structure in *settings.page* as you need. The parser will build an equal JSON structure and extends the *type* nodes with an `@`.

Your root template Setup-TypoScript could look like:

```typo3_typoscript
plugin.tx_schemaorg {
    settings {
        page >
        page {
            type = ProfessionalService
            name = company name
            url = {$themes.configuration.baseurl}
            telephone = +49 123 456 789
            image {
                type = ImageObject
                url = https://www.../logo.svg
                caption = coding.ms
            }
        }
    }
}
```

## Different opening hours on different days

If you have different opening hours on different days, for example on saturday, you can configure it like that:

```typo3_typoscript
plugin.tx_schemaorg {
	settings {
		page {
			#
			#...
			#
			# Opening hours
			openingHoursSpecification {
				0 {
					type = OpeningHoursSpecification
					dayOfWeek {
						# Builds a JSON array into node dayOfWeek
						ARRAY = Monday,Tuesday,Wednesday,Thursday,Friday
					}
					opens = 09:00
					closes = 21:00
				}
				1 {
					type = OpeningHoursSpecification
					dayOfWeek {
						# Builds a JSON array into node dayOfWeek
						ARRAY = Saturday
					}
					opens = 09:00
					closes = 12:00
				}
			}
			#
			#...
			#
		}
	}
}
```


## How to add social media profiles

Links for some social media profiles or pages can be added like this:

```typo3_typoscript
plugin.tx_schemaorg {
	settings {
		page {
			#
			#...
			#
			sameAs {
				# Simply add multiple pages divided by comma
				ARRAY = https://twitter.com/codingms,https://www.instagram.com/codingms/
			}
			#
			#...
			#
		}
	}
}
```



## Links

*   A full documentation for schema you'll find on: http://schema.org/
*   If you need to test your schema data, visit this testing tool: https://search.google.com/structured-data/testing-tool
*   More information about structured data: https://developers.google.com/search/docs/guides/intro-structured-data
