# Dictée Magique

## Overview

Dictée Magique is an interactive French spelling dictation game designed to help users improve their spelling skills through audio-based word dictation. The game features progressive difficulty levels, personalized learning paths, and comprehensive performance tracking.

## Features

### 🎯 Core Gameplay
- **Audio Dictation**: Words are played through audio files for authentic pronunciation practice
- **Progressive Levels**: Four difficulty levels (A, B, C, D) with increasing complexity
- **Session-Based Learning**: Each session presents 15 carefully selected words
- **Real-Time Feedback**: Immediate correction and scoring for each word
- **Points System**: Earn points based on accuracy and speed

### 👤 User Management
- **User Registration**: Create accounts to track personal progress
- **Login System**: Secure authentication for personalized experience
- **Individual Progress Tracking**: Each user has their own word difficulty history
- **Level Advancement**: Automatic progression through difficulty levels

### 📊 Smart Word Selection
- **Adaptive Learning**: Prioritizes words you've struggled with
- **Performance-Based Selection**: Focuses on words with lower success rates
- **Varied Difficulty**: Mixes familiar and challenging words in each session
- **Anti-Repetition**: Avoids recently practiced words when possible

### 🎵 Audio Features
- **Volume Control**: Adjustable audio levels with visual slider
- **Multiple Audio Types**: Support for letters, words, and correction audio
- **Pronunciation Practice**: Clear audio examples for proper spelling

## How to Play

1. **Register/Login**: Create an account or log in to access your personalized game
2. **Start Session**: Begin a new dictation session with 15 words
3. **Listen Carefully**: Audio will play each word clearly
4. **Type the Word**: Enter what you hear in the text input field
5. **Get Feedback**: Receive immediate correction and points
6. **Progress**: Advance through levels as you improve

## Technical Requirements

### Server Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- Audio file support (MP3/WAV)

### Browser Requirements
- Modern web browser with JavaScript enabled
- Audio playback capability
- HTML5 support

## Installation

1. **Database Setup**:
   - Import `dictee2026.sql` into your MySQL database
   - Configure database connection in `php/db_connect.php`

2. **File Structure**:
   - Place all files in your web server's document root
   - Ensure `audio/` directory is accessible and contains word audio files
   - Set proper permissions for file uploads if needed

3. **Configuration**:
   - Update database credentials in `php/db_connect.php`
   - Ensure audio files are organized by level (A, B, C, D)
   - Configure web server for PHP execution

## Database Schema

### Key Tables
- `users`: User accounts and preferences
- `words`: Master word list with levels and audio paths
- `words_users`: User-specific word performance tracking
- `user_words_level`: Level progression data

### Word Levels
- **Level A**: Basic vocabulary (e.g., animal, fille, noir)
- **Level B**: Intermediate words (e.g., acier, besoin, chaise)
- **Level C**: Advanced vocabulary
- **Level D**: Complex words and spellings

## File Structure

```
dictee/
├── index.php              # Main game interface
├── login.php              # User authentication
├── register.php           # User registration
├── logout.php             # Session termination
├── audio/                 # Audio files directory
│   ├── lettres/          # Letter pronunciation
│   ├── mots/             # Word audio by level
│   │   ├── A/
│   │   ├── B/
│   │   ├── C/
│   │   └── D/
│   ├── ordres/           # Command audio
│   └── sound/            # Sound effects
├── css/                  # Stylesheets
├── js/                   # JavaScript files
├── php/                  # Server-side logic
├── pix/                  # Images and icons
└── DB.sql         # Database schema
```

## Gameplay Mechanics

### Scoring System
- Correct spelling: Full points
- Minor errors: Partial credit
- Multiple attempts: Reduced points
- Speed bonus: Faster correct answers earn more points

### Level Progression
- Complete words in current level to unlock next
- Maintain accuracy threshold to advance
- System tracks overall performance across all words

### Word Selection Algorithm
1. Priority: Words with 3-4 difficulty ratings (most struggled)
2. Secondary: Words with 2 ratings not asked today
3. Tertiary: Words with 1 rating (never asked)
4. Fallback: Previously correct words for review

## Customization

### Adding Words
- Use `uploadWords.php` to add new vocabulary
- Include audio files in appropriate level directories
- Words are automatically categorized by difficulty

### Audio Management
- Audio files should be named consistently
- Support for MP3 and WAV formats
- Volume levels adjustable per user

## Troubleshooting

### Common Issues
- **Audio not playing**: Check browser audio permissions
- **Words not loading**: Verify database connection
- **Login issues**: Clear browser cache and cookies
- **Level not advancing**: Check word completion requirements

### Debug Mode
- Enable browser developer tools for JavaScript errors
- Check PHP error logs for server-side issues
- Verify database queries in `php/functions.php`

## Contributing

To contribute to Dictée Magique:
1. Add new words with corresponding audio files
2. Improve user interface and experience
3. Enhance scoring algorithms
4. Add new difficulty levels or game modes

## License

This project is developed for educational purposes. Please respect copyright and licensing for any audio files used.

## Support

For technical support or questions about the game mechanics, please refer to the code comments and database schema documentation.</content>
<parameter name="filePath">c:\Apache24\htdocs\dictee\README.md