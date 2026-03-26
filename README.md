# web4-presence-spec
The structured presence standard for AI agent search

# presence.w4 — Structured Presence Standard for AI Agent Search

**Draft v0.1 — March 17, 2026**
**Author: Shawn McGinnis, FerretDev**
**Site: web4presence.org**

Schema.org was built for Google.
presence.w4 is built for AI agents.

AI agents fetch 3.5mb of HTML to extract
2kb of business data. presence.w4 fixes that.

A structured 2kb identity file at a known
endpoint. Direct. Typed. Fresh. Yours.

## The problem
AI agents scrape entire webpages to find
basic business information. That's 3.5mb
to extract 2kb of useful data. Slow.
Expensive. Inaccurate.

## The solution
A dedicated structured data endpoint at a known location:
```
yourdomain.com/.well-known/presence.w4
```

WordPress fallback:
```
yourdomain.com/wp-json/web4/v1/presence
```

2kb. Typed fields. Known format.
No page fetch. No inference. No scraping.

## Minimum viable presence.w4
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
  "for:agents:context": "Joe's Plumbing is a locally owned emergency plumbing service in Hinton Alberta Canada. Available 24 hours. Serving Hinton and within 80km.",
  "for:agents:keywords": ["plumber", "emergency plumbing", "Hinton"],
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

## Spec
Full specification at w4spec.dev

## WordPress Plugin
Free plugin coming to WordPress.org
Generates presence.w4 from existing
site data. Install and forget.

## License
MIT — open forever
