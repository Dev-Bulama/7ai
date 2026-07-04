# 7AI Conference Operations System — Testing Guide

This guide walks through every conference feature step-by-step.
All test accounts use the password: **`password`**

---

## Test Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin (test) | admin.test@7ai.africa | password |
| Front Desk 1 | frontdesk1@7ai.africa | password |
| Front Desk 2 | frontdesk2@7ai.africa | password |
| Lunch Scanner 1 | lunch1@7ai.africa | password |
| Lunch Scanner 2 | lunch2@7ai.africa | password |

> Run `php artisan conference:seed-test-data` on the server to create these accounts.

---

## Step 1 — Admin Login

1. Go to `https://7ai.africa/login`
2. Enter your admin email and password
3. You should land on the Admin Dashboard at `/admin`
4. Look for **"Conference"** in the left sidebar (under Forms section)
5. Click **Conference** — you should see the Conference Management dashboard

**Expected:** Stats show total registrations, check-ins, and staff counts.

---

## Step 2 — Create a Conference Form (or use existing)

> If the Abuja or LearnAI form already exists, skip to Step 3.

1. Go to **Admin → Form Builder**
2. Click **New Form**
3. Fill in: Name, Slug, Public URL Path (e.g. `/abuja`)
4. Add fields: Full Name, Email, Phone, Occupation, etc.
5. Click **Save**

---

## Step 3 — Enable Conference Mode on a Form

1. Go to **Admin → Form Builder**
2. Find your form, click **Edit**
3. Scroll down to the **"🎪 Conference Mode"** section
4. Click **"Enable Conference Mode"**
5. Click **Participants** — should show the participant list

**Expected:** Form is now a conference form. Conference dashboard shows it.

---

## Step 4 — Submit the Public Registration Form

1. Open a new tab (incognito)
2. Go to `https://7ai.africa/abuja` (or your form's public URL)
3. Fill in: Full Name, Email, Phone, Occupation
4. Click **Submit Registration**

**Expected:** Success message shown. Submission appears in Admin > Conference > Participants.

---

## Step 5 — Generate Participant IDs and QR Tokens

On the server, run:

```bash
php artisan conference:generate-participant-qrcodes
```

Or with a specific form:

```bash
php artisan conference:generate-participant-qrcodes --form=abuja
```

**Expected output:**
```
[Abuja Conference] Generated 15 QR tokens.
```

In Admin → Conference → Participants: all rows should show ✓ in the QR column.

---

## Step 6 — View Participant Badge/Card

1. Go to **Admin → Conference → [Form] → Participants**
2. Find a participant with a QR token (✓ in QR column)
3. Click **🏷 Badge** button
4. A new tab opens with the printable badge

**Expected:**
- Participant name displayed
- Participant ID displayed
- QR code rendered as a scannable image
- Event name shown in the header
- Print button works

---

## Step 7 — Export Participants to CSV

1. Go to **Admin → Conference → [Form] → Participants**
2. Click **⬇ Export CSV** (top right)

**Expected:** CSV file downloads with columns:
- Participant ID, QR Token, Checked In, Checked In At, Checked In By, Lunch Collected, Lunch At, [all form fields], Submitted At

---

## Step 8 — Create Front Desk Staff Account

1. Go to **Admin → Conference → Staff Accounts**
2. Click **+ Add Staff**
3. Fill in:
   - Name: Front Desk One
   - Email: frontdesk1@7ai.africa
   - Role: Front Desk Staff
   - Password: (choose a secure password)
4. Click **Create Account & Send Credentials**

**Expected:** Staff account created. Credentials email sent (if SMTP configured).

> Or just run `php artisan conference:seed-test-data` to create all test accounts.

---

## Step 9 — Login as Front Desk Staff

1. Open an incognito window
2. Go to `https://7ai.africa/login`
3. Login with: `frontdesk1@7ai.africa` / `password`

**Expected:** Redirected to the standard dashboard (or admin if they have admin role).

4. Go to `https://7ai.africa/staff/front-desk`

**Expected:** Front Desk portal loads with dark background, stats bar, QR scanner input, and manual lookup.

---

## Step 10 — Search for a Participant (Front Desk)

1. On the Front Desk portal: `https://7ai.africa/staff/front-desk`
2. In the **Manual Lookup** section, type a participant's name (e.g. "Aisha")
3. Click **Search** or press Enter

**Expected:**
- Matching participant(s) appear
- Shows: Name, Participant ID, Email, Phone
- Shows "Checked In ✓" or **Check In** button

---

## Step 11 — Check-In a Participant (Manual)

1. In the search results, find a participant NOT yet checked in
2. Click **Check In** button next to their name

**Expected:**
- Button changes to ✓ Done
- Participant is now marked as checked in
- Audio beep plays (on supported browsers)
- In Admin → Participants, row turns green, shows check-in time

---

## Step 12 — Check-In via QR Code (Front Desk)

1. Open a participant's badge: Admin → Conference → [Form] → Participants → Badge
2. Note the QR token value (or scan the QR code with a phone camera to get the token)
3. Back on the Front Desk portal, in the **QR Code Scanner** input:
   - Type or paste the QR token
   - Press Enter or click **Check In**

**Expected:**
- Green success box appears: "✓ Welcome, [Name]!"
- Second scan of same token shows: "⚠ Already checked in at HH:MM"

---

## Step 13 — Verify Shared State (Second Front Desk Staff)

1. Open another browser/incognito window
2. Login as `frontdesk2@7ai.africa`
3. Go to `/staff/front-desk`
4. Search for the participant you just checked in

**Expected:** Participant shows as already checked in (checked_in_by shows the other staff member's name in Admin).

---

## Step 14 — Login as Lunch Scanner Staff

1. Open a new incognito window
2. Login as `lunch1@7ai.africa` / `password`
3. Go to `https://7ai.africa/staff/lunch-scanner`

**Expected:** Lunch Scanner portal loads with orange/warm color scheme, stats showing checked-in vs lunch served.

---

## Step 15 — Scan QR for Lunch

1. On the Lunch Scanner portal, in the scan input
2. Type or paste a participant's QR token (must be checked-in first)
3. Press Enter or click **Confirm**

**Expected:**
- Orange success box: "✓ Lunch served to [Name]"
- Audio confirmation beep
- Stats counter decrements "Remaining"

---

## Step 16 — Scan Same QR Again (Duplicate Check)

1. Immediately scan the same QR token again

**Expected:**
- Yellow warning box: "⚠ Lunch already collected at HH:MM"
- No second lunch is recorded

---

## Step 17 — Test Invalid QR

1. Type a random string (e.g. "INVALID123") in the scanner input
2. Press Enter

**Expected:** Red error box: "Participant not found. Invalid QR code."

---

## Step 18 — Test Non-Checked-In Participant (Lunch Scanner)

1. Find a participant in Admin who is NOT checked in (attendance_verified = false)
2. Try their QR token on the Lunch Scanner

**Expected:** Red error box: "⛔ Not checked in. Participant must check in first."

---

## Step 19 — View Admin Dashboard Reports

1. Go to **Admin → Conference**
2. Verify stats are live (not fake):
   - Total Registered matches submission count
   - Checked In matches actual check-ins
   - Lunch Collected matches actual served count
   - Staff counts match actual staff accounts
3. Check Recent Check-ins and Recent Scan Activity panels

---

## Step 20 — View Scan Logs

1. Go to **Admin → Conference → [Form] → Logs** (📋 button)

**Expected:** Table shows all scan events with:
- Timestamp
- Action type (check_in / lunch / manual_verify)
- Participant ID
- Staff member name
- IP address

---

## Step 21 — Verify Permission Boundaries

### Admin can access everything:
- ✓ `/admin/*` — all admin pages
- ✓ `/staff/front-desk`
- ✓ `/staff/lunch-scanner`

### Front Desk Staff:
- ✓ `/staff/front-desk` — accessible
- ✗ `/admin/*` — should get 403 or redirect

### Lunch Staff:
- ✓ `/staff/lunch-scanner` — accessible
- ✗ `/admin/*` — should get 403 or redirect

### Unauthenticated:
- ✗ `/staff/front-desk` — redirected to login
- ✗ `/staff/lunch-scanner` — redirected to login

---

## Step 22 — Test Conference Settings

1. Go to **Admin → Conference → [Form] → ⚙ Settings**
2. Change: Event Name, Event Date, Venue, ID Prefix, Colors
3. Click **Save Settings**

**Expected:** Settings saved. Badge cards reflect updated info.

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| "No conference forms" | Enable conference mode on a form via Form Builder |
| QR token missing | Run `php artisan conference:generate-participant-qrcodes` |
| Staff can't log in | Check `is_active = true` on their account |
| Export crashes | Ensure form has at least one submission |
| Badge shows no QR | Ensure `simplesoftwareio/simple-qrcode` is installed (`composer require simplesoftwareio/simple-qrcode:~4`) |
| 403 on staff portal | Assign correct role (`front-desk-staff` or `lunch-staff`) |

---

## Commands Reference

```bash
# Run migrations
php artisan migrate --force

# Create test accounts and 15 dummy participants
php artisan conference:seed-test-data

# Generate QR tokens for all conference forms
php artisan conference:generate-participant-qrcodes

# Generate for a specific form only
php artisan conference:generate-participant-qrcodes --form=abuja

# Re-generate (overwrite existing)
php artisan conference:generate-participant-qrcodes --force

# Clear caches
php artisan optimize:clear
```
