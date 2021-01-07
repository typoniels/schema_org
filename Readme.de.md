# Schema.org für TYPO3

Diese Erweiterung für TYPO3 ist einfach zu verwenden - einfach installieren und das mitgelieferte Static-Template einbinden.

## Konfiguration

Sie können die Schema-Daten einfach mit Hilfe von Setup-TypoScript konfigurieren. Die Standard-Konfigration sieht wie folgt aus:

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

Für Ihre eigenen Schema-Daten müssen Sie einfach die Struktur in *settings.page* nach Ihren Bedürfnissen anpassen. Der interne Parser erstellt aus dieser Struktur ein JSON und erweitert *type* Knoten mit einem `@`.

Ihr Setup-TypoScript könnte wie folgt aussehen:

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

## Unterschiedliche Öffnungszeiten an Wochentagen

Wenn Sie unterschiedliche Öffnungszeiten an Wochentagen haben, bspw. am Samstag, können Sie das wie folgt konfigurieren:

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


## Socialmedia-Profile hinzufügen

Links zu Socialmedia-Profilen oder anderen Seiten können wie folgt hinzugefügt werden:

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

*   Komplette Dokumentation zu Schema-Daten: http://schema.org/
*   Wenn Sie Ihre Schema-Daten testen möchten, können Sie diese Tools verwenden: https://search.google.com/structured-data/testing-tool oder https://search.google.com/test/rich-results
*   Mehr Informationen zu Structured-Data: https://developers.google.com/search/docs/guides/intro-structured-data
