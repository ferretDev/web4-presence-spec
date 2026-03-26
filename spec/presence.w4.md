# presence.w4 Specification

**Version: 0.1 Draft**  
**Date: March 17, 2026**  
**Author: Shawn McGinnis, FerretDev**

## Overview

presence.w4 is a structured JSON file 
published at a known endpoint on any domain.
It provides AI agents with direct access 
to structured business identity without 
fetching entire webpages.

MIME type: `application/web4+json`  
File extension: `.w4`

## Endpoint

Primary (recommended):
```
yourdomain.com/.well-known/presence.w4
```

WordPress REST (fallback):
```
yourdomain.com/wp-json/web4/v1/presence
```

## Namespace Convention

Every field is prefixed by purpose category:
```
meta:       file metadata
identity:   who you are
local:      where you are
trust:      why believe you
brand:      how you look
for:        consumption hints
blocks:     renderable content
actions:    what agents can do
compat:     backwards compatibility
```

## Required Fields
```
meta:schema
meta:type
meta:version
meta:updated
meta:ttl
identity:name
identity:type
local:city
local:country
for:agents:context
actions:primary
```

## Controlled Vocabularies

### identity:type
```
LocalBusiness | Agency | Freelancer |
Person | Organization | RetailStore |
Restaurant | Medical | Legal |
Financial | Education | NonProfit |
Government | Event | Product | Service
```

### block:type
```
HeroBlock | ContactBlock | ServiceBlock |
ProductBlock | TeamBlock | ReviewBlock |
EventBlock | GalleryBlock | FaqBlock |
SocialBlock | OfferBlock | LocationBlock |
CredentialBlock
```

### action:type
```
call | email | book | quote |
purchase | directions | follow |
subscribe | download | inquire
```

### local:reach:model
```
local-only | remote-first |
hybrid | global | on-site
```

## Data Standards
```
Dates:       ISO 8601
Currency:    ISO 4217
Language:    BCP 47
Country:     ISO 3166-1 alpha-2
Coordinates: WGS84 [latitude, longitude]
TTL:         seconds (integer)
```

## Validation Scoring
```
Required fields only        40/100
+ Brand complete            60/100
+ Trust signals             70/100
+ Full block set            85/100
+ Compatibility layer       95/100
+ Verified                 100/100
```

## Minimum Valid File
```json
{
  "meta:schema": "https://web4presence.org/schema/2026-03-17",
  "meta:type": "LocalBusiness",
  "meta:version": "0.1",
  "meta:updated": "2026-03-17T14:00:00Z",
  "meta:language": "en-CA",
  "meta:ttl": 86400,

  "identity:name": "Joe's Plumbing",
  "identity:type": "LocalBusiness",
  "identity:tagline": "Hinton's most trusted plumber",

  "local:city": "Hinton",
  "local:region": "Alberta",
  "local:country": "CA",
  "local:reach:model": "local-only",

  "trust:verified": false,
  "trust:since": "2008",

  "for:agents:context": "Joe's Plumbing is a 
    locally owned emergency plumbing service 
    in Hinton Alberta Canada. Available 24 
    hours. Serving Hinton and within 80km.",

  "for:agents:keywords": [
    "plumber",
    "emergency plumbing",
    "Hinton"
  ],

  "blocks": [
    {
      "block:type": "ContactBlock",
      "block:phone": "+17805550123",
      "block:cta:label": "Call Now",
      "block:cta:action": "call",
      "block:cta:endpoint": "tel:+17805550123"
    }
  ],

  "actions:primary": {
    "action:type": "call",
    "action:label": "Call Now",
    "action:endpoint": "tel:+17805550123"
  },

  "compat:schema-org": "/schema.json",
  "compat:llms-txt": "/llms.txt"
}
```

## LLMs.txt Integration

Add to your LLMs.txt:
```
X-W4-Presence: /.well-known/presence.w4
```

## robots.txt Integration
```
User-agent: GPTBot
Allow: /.well-known/presence.w4

User-agent: ClaudeBot
Allow: /.well-known/presence.w4

User-agent: PerplexityBot
Allow: /.well-known/presence.w4

User-agent: CCBot
Allow: /.well-known/presence.w4
```

## HTTP Discovery

Add to page headers:
```
Link: </.well-known/presence.w4>; 
      rel="presence"; 
      type="application/web4+json"
```

Add to HTML head:
```html
<link rel="presence" 
      href="/.well-known/presence.w4"
      type="application/web4+json">
```

## Extensions

- [Retail Extension](retail.md) — 
  inventory, wayfinding, freshness
- [Commerce Extension](commerce.md) — 
  catalog, offers, payments
- [Person Extension](person.md) — 
  professional identity

## License

MIT — open forever
